<?php
/**
 * Hoststar - MultiInvoiceWorker
 * This class contains methods to
 * fill invoice data from old tables into the new tables
 */

namespace Workers;

use Core\Exceptions\ConfigException;
use DateInterval;
use DateTime;
use Exception;
use finfo;
use PDO;
use Core\App;
use Core\LogDriver;
use Core\SendmailDriver;
use Core\WgetDriver;

/**
 *
 */
class MultiInvoiceWorker
{
    const INVOICE_PAYED = 1;
    const INVOICE_UNPAYED = 0;

    /** @var string */
    const DEFAULT_INVOICE_INTERVAL = "P10M"; // 10 month ago

    /** @var float */
    const DEFAULT_TAX = 7.7;

    /** @var string */
    private static $fill_tables_sql = __DIR__ . '/../Db/sql/multiInvoiceWorker/fill_invoice_tables.sql';

    /**
     * @param $invoice_date
     * @return float
     * @throws Exception
     */
    public static function getActualTaxForDate($invoice_date)
    {
        $executeMsg = LogDriver::executingMessage("Try to obtain product-tax via database ({{mwst}})", 2);
        $date = new DateTime($invoice_date);
        $repl['timestamp_start'] = $date->getTimestamp();
        $query = "SELECT mwst FROM {{mwst}} WHERE start_datum <= :timestamp_start ORDER BY start_datum DESC LIMIT 1";
        $res = App::$db->getOne($query, $repl);
        if (isset($res['mwst'])) {
            $product_tax = doubleval($res['mwst']);
            $executeMsg->showSuccess();
        } else {
            $product_tax = self::DEFAULT_TAX;
            $executeMsg->showError();
            LogDriver::warning("const DEFAULT_TAX=" . self::DEFAULT_TAX . " for product-tax will be used.", 2);
        }
        LogDriver::info("product_tax set to value [warn]{$product_tax}%[/warn]", 1);
        return $product_tax;
    }

    /**
     * @return bool
     */
    public function checkTablesInstalled()
    {
        $check_table_res = App::$db->getOne("DESCRIBE TABLE {{invoice_products}}");
        return is_array($check_table_res);
    }

    /**
     * Fill invoice tables, should be used every day by cron
     * @param string|null $for_the_date date in format yyyy-mm-dd if null current date will be used
     * @return array|false
     * @throws ConfigException
     * @throws \Core\Exceptions\DbException
     * @throws Exception
     */
    public function fillInvoiceTable($for_the_date = null)
    {
        /* get the date for which we are select data from old tables */
        if ($for_the_date === null) {
            LogDriver::info("No manual date for select invoices given.", 2);
            $executeMsg = LogDriver::executingMessage("Try to obtain date via database and constant AUTOMATIC_INVOICE_INTERVAL", 2);
            if (defined('AUTOMATIC_INVOICE_INTERVAL')) {
                $tmp = App::$db->getOne("SELECT date_sub(CURRENT_DATE, INTERVAL " . AUTOMATIC_INVOICE_INTERVAL . ") as for_the_date, CURRENT_DATE as cur_date");
            }
            if (isset($tmp['for_the_date'], $tmp['cur_date'])) {
                $for_the_date = $tmp['for_the_date'];
                $cur_date = $tmp['cur_date'];
                $executeMsg->showSuccess();
            } else {
                $executeMsg->showError();
                $executeMsg = LogDriver::executingMessage("Try to obtain date via DateTime and constant DEFAULT_INVOICE_INTERVAL=" . self::DEFAULT_INVOICE_INTERVAL, 2);
                $date = new DateTime('now');
                $cur_date = $date->format('Y-m-d');
                $date->sub(new DateInterval(self::DEFAULT_INVOICE_INTERVAL));
                $for_the_date = $date->format('Y-m-d');
                $executeMsg->showSuccess();
            }
        } else {
            try {
                LogDriver::info("Manual date for select invoices given.", 1);
                $date = new DateTime($for_the_date);
                $for_the_date = $date->format('Y-m-d');
                $cur_date = $date->add(new DateInterval(self::DEFAULT_INVOICE_INTERVAL))->format('Y-m-d');
            } catch (Exception $e) {
                LogDriver::error("Unfortunately date that you give doesn't look like a date.", 1);
                LogDriver::error("Process terminated.", 1);
                throw new Exception('');
            }
        }
        LogDriver::info("All invoices for the date [warn]{$for_the_date}[/warn] will be processed.", 1);
        LogDriver::info("New date [warn]{$cur_date}[/warn] for invoices will be set.", 1);

        /* get actual tax for the invoices */
        $product_tax = self::getActualTaxForDate($cur_date);

        /* get query from sql file */
        $executeMsg = LogDriver::executingMessage("Getting query from file '" . self::$fill_tables_sql . "'", 2);
        $query = file_get_contents(self::$fill_tables_sql);
        if (!$query) {
            $executeMsg->showError();
            LogDriver::error("Process terminated.", 1);
            throw new Exception('');
        } else {
            $executeMsg->showSuccess();
            $query = trim($query);
        }

        /* if debug mode, limit select to {debug.limit_fill_db_query} records */
        if (IS_DEBUG) {
            if (!App::$config->get('debug.limit_fill_db_query')) {
                throw new ConfigException('Config param debug.limit_fill_db_query is required in DEBUG_MODE');
            }
            $query .= " LIMIT " . App::$config->get('debug.limit_fill_db_query');
        }

        /* execute query */
        //dd(App::$db->prepareSql($query,['FOR_THE_DATE' => $for_the_date]));
        $executeMsg = LogDriver::executingMessage("Executing query to select data from old tables", 2);
        $res = App::$db->exec($query, [
            'FOR_THE_DATE' => $for_the_date,
            'CUR_DATE' => $cur_date,
        ]);
        if ($res) {
            $executeMsg->showSuccess();
            $ret['count_invoices_success'] = 0;
            $ret['count_invoices_warn'] = 0;
            $ret['count_invoices_error'] = 0;
            $current_client = null;

            /* loop for filling invoices table */
            while (($line = $res->fetch(PDO::FETCH_ASSOC)) !== false) {
                /**/
                if ($current_client !== $line['id_kunde']) {
                    $current_client = $line['id_kunde'];
                    if (isset($invoice_data) && sizeof($invoice_data)) {
                        $resultCreate = self::createInvoice($invoice_data);
                        if ($resultCreate === true) $ret['count_invoices_success']++;
                        elseif ($resultCreate === null) $ret['count_invoices_warn']++;
                        else $ret['count_invoices_error']++;
                    }
                    $invoice_data = [];
                }
                /**/
                $line['product_amount'] = doubleval($line['product_amount']);
                $line['product_tax'] = $product_tax;
                $invoice_data[] = $line;
            }
            if (isset($invoice_data) && sizeof($invoice_data)) {
                $resultCreate = self::createInvoice($invoice_data);
                if ($resultCreate === true) $ret['count_invoices_success']++;
                elseif ($resultCreate === null) $ret['count_invoices_warn']++;
                else $ret['count_invoices_error']++;
            }

            /* loop for filling invoices table is finished */
            LogDriver::createMessage("Finished filling data for invoices", 1, 'info')
                ->messageAppend("\n\tSuccess invoices:\t[success]{$ret['count_invoices_success']}[/success]")
                ->messageAppend("\n\tWarnings invoices:\t[warn]{$ret['count_invoices_warn']}[/warn]")
                ->messageAppend("\n\tError invoices:\t\t[error]{$ret['count_invoices_error']}[/error]")
                ->show();
            return $ret;
        } else {
            $executeMsg->showError();
            LogDriver::warning(App::$db->getErrors(), 3, false);
            LogDriver::error("Process terminated.", 1);
            return false;
        }
    }

    /**
     * Write invoice data into DB
     * @param array $products
     * @return bool|null
     * @throws \Core\Exceptions\DbException
     */
    private static function createInvoice(array $products)
    {
        /* start */
        $products[0]['invoice_amount'] = doubleval(array_sum(array_column($products, 'product_amount')));
        $products[0]['invoice_amount'] = number_format($products[0]['invoice_amount'], 2, '.', '');
        $invoice_products_count = count($products);
        $executeMsgInvoice = LogDriver::executingMessage("Create invoice number=[warn]:INVOICE_ID[/warn] for client_id=[warn]:CLIENT_ID[/warn] (products_count=[warn]:PRODUCTS_COUNT[/warn], amount=[warn]:AMOUNT[/warn])", 2);
        $executeMsgInvoice->setData([
            ':CLIENT_ID' => $products[0]['id_kunde'],
            ':PRODUCTS_COUNT' => $invoice_products_count,
            ':AMOUNT' => $products[0]['invoice_amount'],
        ]);

        /* generating unique key and check invoice that it is not in DB yet */
        $unique_hash = sha1(json_encode($products));
        $products[0]['invoice_unique_hash'] = $unique_hash;
        $check = App::$db->getOne("SELECT invoice_id FROM {{invoices}} WHERE invoice_unique_hash = :unique_hash", [
            'unique_hash' => $unique_hash,
        ]);
        if (isset($check['invoice_id'])) {
            $executeMsgInvoice->setData([
                ':INVOICE_ID' => $check['invoice_id'],
            ]);
            $executeMsgInvoice->showWarn();
            LogDriver::warning("This invoice already exist in database.", 3, false);
            LogDriver::warning("Invoice data:\n" . dumpIntoStr($products), 4, false);
            return null;
        }

        /* begin insert invoice and its products into DB with transaction */
        App::$db->beginTransaction();

        /* insert record about invoice and client data */
        $insert_invoice = "
        INSERT INTO {{invoices}} 
            (invoice_unique_hash, invoice_amount, invoice_date, invoice_payed, invoice_lang, id_kunde, client_company_name, client_first_name, client_second_name, client_email, client_phone, client_postcode, client_country, client_city, client_street) 
        VALUES 
            (:invoice_unique_hash, :invoice_amount, :invoice_date, 0, :invoice_lang, :id_kunde, :client_company_name, :client_first_name, :client_second_name, :client_email, :client_phone, :client_postcode, :client_country, :client_city, :client_street);
        ";

        /* insert records about products for this invoice */
        if (App::$db->exec($insert_invoice, $products[0])) {
            $invoice_id = App::$db->lastInsert();
            $executeMsgInvoice->setData([
                ':INVOICE_ID' => $invoice_id,
            ]);
            $sql_values = [];
            foreach ($products as $key => $product) {
                $product['invoice_id'] = $invoice_id;
                $sql_values[] = App::$db->prepareSql("(
                    :invoice_id, 
                    :period_start, 
                    :period_end, 
                    :product_name, 
                    :product_count, 
                    :product_amount, 
                    :product_tax, 
                    :product_table, 
                    :product_id, 
                    :product_abo_table, 
                    :product_abo_id, 
                    :product_prefix  
                )", $product);
            }

            $insert_product = "
                INSERT INTO {{invoice_products}} (
                    invoice_id, 
                    period_start, 
                    period_end, 
                    product_name, 
                    product_count, 
                    product_amount, 
                    product_tax, 
                    product_table, 
                    product_id, 
                    product_abo_table, 
                    product_abo_id, 
                    product_prefix  
                ) VALUES " . implode(', ', $sql_values);

            $executeMsgProducts = LogDriver::executingMessage("\tInsert [warn]" . (count($sql_values)) . "[/warn] products for invoice=[warn]{$invoice_id}[/warn]", 3);
            if (!App::$db->exec($insert_product)) {
                if (LogDriver::getVerboseLevel() > 2) {
                    $executeMsgInvoice->show();
                } else {
                    $executeMsgInvoice->showError();
                }
                $executeMsgProducts->showError();
                LogDriver::warning(App::$db->getErrors(), 4, false);
                App::$db->rollBack();
                return false;
            } else {
                if (LogDriver::getVerboseLevel() > 2) {
                    $executeMsgInvoice->show();
                } else {
                    $executeMsgInvoice->showSuccess();
                }
                $executeMsgProducts->showSuccess();
            }
        } else {
            $executeMsgInvoice->showError();
            LogDriver::warning(App::$db->getErrors(), 3, false);
            App::$db->rollBack();
            return false;
        }
        App::$db->commit();
        return true;
    }

    /**
     * @return array|false
     */
    public function sendFirstMailForInvoices()
    {
        LogDriver::info("All invoices for wich need to sent fist-time email, will be processed.", 1);
        $executeMsg = LogDriver::executingMessage("Executing query to select clients to send them first-time invoice", 2);
        $query = "SELECT * 
                  FROM {{invoices}} AS I
                  INNER JOIN {{invoice_products}} AS P ON I.invoice_id = P.invoice_id
                  WHERE (I.invoice_payed = :unpayed)
                    AND (I.invoice_sent_date IS NULL)";
        $res = App::$db->exec($query, ['unpayed' => self::INVOICE_UNPAYED]);
        if ($res) {
            $executeMsg->showSuccess();
            $ret['count_invoices_success'] = 0;
            $ret['count_invoices_warn'] = 0;
            $ret['count_invoices_error'] = 0;
            $current_client = null;

            /* loop for sending first letter invoices */
            while (($line = $res->fetch(PDO::FETCH_ASSOC)) !== false) {
                /**/
                if ($current_client !== $line['id_kunde']) {
                    $current_client = $line['id_kunde'];
                    if (isset($invoice_data) && sizeof($invoice_data)) {
                        $resultSent = $this->sendInvoice($invoice_data);
                        if ($resultSent === true) $ret['count_invoices_success']++;
                        elseif ($resultSent === null) $ret['count_invoices_warn']++;
                        else $ret['count_invoices_error']++;
                    }
                    $invoice_data = [];
                }
                /**/
                $invoice_data[] = $line;
            }
            if (isset($invoice_data) && sizeof($invoice_data)) {
                $resultSent = $this->sendInvoice($invoice_data);
                if ($resultSent === true) $ret['count_invoices_success']++;
                elseif ($resultSent === null) $ret['count_invoices_warn']++;
                else $ret['count_invoices_error']++;
            }

            /* loop for sending first letter invoices is finished */
            LogDriver::createMessage("Finished sending first letter with invoices", 1, 'info')
                ->messageAppend("\n\tSuccess:\t[success]{$ret['count_invoices_success']}[/success]")
                ->messageAppend("\n\tWarnings:\t[warn]{$ret['count_invoices_warn']}[/warn]")
                ->messageAppend("\n\tError:\t\t[error]{$ret['count_invoices_error']}[/error]")
                ->show();
            return $ret;
        } else {
            $executeMsg->showError();
            LogDriver::warning(App::$db->getErrors(), 3, false);
            LogDriver::error("Process terminated.", 1);
            return false;
        }
    }

    /**
     * @param array $data
     * @return bool|null
     * @throws ConfigException
     */
    public static function sendInvoice(array $data)
    {
        /* in debug mode we do not send email to real client */
        $debug_email_warn_message = "Real client email is [success]{$data[0]['client_email']}[/success], but in debug mode it is replaced by debug-variant";
        if (IS_DEBUG) {
            if (!App::$config->get('debug.sendmail_debug_email_instead_clients')) {
                throw new ConfigException('Config param debug.sendmail_debug_email_instead_clients is required in DEBUG_MODE');
            }
            $data[0]['email'] = App::$config->get('debug.sendmail_debug_email_instead_clients');
        }
        $executeMsgInvoice = LogDriver::executingMessage("Sending message for invoice_id=[warn]{$data[0]['invoice_id']}[/warn] to client-email=[warn]{$data[0]['email']}[/warn]", 2);

        /* try get pdf for invoice_id */
        if (false === ($pdf = self::getPdfInvoice($data))) {
            $executeMsgInvoice->showError();
            LogDriver::warning("Sending letter skipped for invoice_id=[warn]{$data[0]['invoice_id']}[/warn] cause failed receive pdf for it.", 3);
            return false;
        }

        /* get mail-template for client depend on his language settings */
        if (!App::$config->get('sendmail_templates_dir.first_letter')) {
            throw new ConfigException('Config param sendmail_templates_dir.first_letter is required');
        }
        $tpl_file = App::$config->get('sendmail_templates_dir.first_letter') . "/" . $data[0]['invoice_lang'] . ".php";
        if (!file_exists($tpl_file)) {
            $tpl_file = App::$config->get('sendmail_templates_dir.first_letter') . "/en.php";
        }
        if (!file_exists($tpl_file)) {
            $executeMsgInvoice->showError();
            LogDriver::warning("Sending letter failed cause no template was presented", 3);
            return false;
        }
        $tpl = require($tpl_file);
        if (empty($tpl['html']) || empty($tpl['from_email'])) {
            $executeMsgInvoice->showError();
            LogDriver::warning("Sending letter failed cause template has wrong configuration", 3);
            return false;
        }

        /* try to send email throw MailDriver */
        if (function_exists('html2text')) {
            $tpl['text'] = html2text($tpl['html']);
        } else {
            $tpl['text'] = strip_tags($tpl['html']);
        }
        if (!App::$config->get('company_data')) {
            throw new ConfigException('Config param company_data is required');
        }
        $mailer = SendmailDriver::init()
            ->setFrom($tpl['from_email'], (isset($tpl['from_name']) ? $tpl['from_name'] : $tpl['from_email']))
            ->setTo($data[0]['client_email'], "{$data[0]['client_first_name']} {$data[0]['client_second_name']}")
            ->setSubject($tpl['subject'])
            ->setBodyHtml($tpl['html'])
            ->setBodyText($tpl['text'])
            ->setReplaceData($data[0])
            ->setReplaceData(App::$config->get('company_data', []))
            ->addAttachment("Invoice-for-{$data[0]['client_first_name']}-{$data[0]['client_second_name']}.pdf", $pdf, 'application/pdf');
        $res = $mailer->send();
        if ($res === false) {
            $executeMsgInvoice->showError();
            LogDriver::error("For invoice [warn]{$data[0]['invoice_id']}[/warn], sent email failed.", 3);
            LogDriver::warning("Errors stack:\n" . dumpIntoStr($mailer->getErrors()), 4, false, true);
            return false;
        } elseif (isset($res['queue_id'])) {
            $executeMsgInvoice->showSuccess();
            if (IS_DEBUG) LogDriver::warning($debug_email_warn_message, 3);
            LogDriver::warning("Mailer answer: queue_id=[success]{$res['queue_id']}[/success]", 3);
            $resultSent = true;
        } else {
            $executeMsgInvoice->showWarn();
            if (IS_DEBUG) LogDriver::warning($debug_email_warn_message);
            LogDriver::warning("For invoice_id=[warn]{$data[0]['invoice_id']}[/warn], mailer answer was NULL. Probably mailer need to check or serve mail-system", 3);
            // Probably here we must return false
            $resultSent = null;
        }
        LogDriver::warning("Full answer from mailer:\n" . dumpIntoStr($res['full_answer']), 4, false, true);

        /* update invoice status and set info from mailer */
        $executeMsgInvoice = LogDriver::executingMessage("Executing query to update invoice data for invoice_id=[warn]{$data[0]['invoice_id']}[/warn]", 2);
        $query = "UPDATE {{invoices}} SET 
                        invoice_payed = :invoice_payed,
                        invoice_sent_date = CURRENT_DATE, 
                        mailer_last_full_answer = :full_answer,
                        mailer_last_queue_id = :queue_id,
                        mailer_last_status = :status
                  WHERE invoice_id = :invoice_id";
        $res['invoice_id'] = intval($data[0]['invoice_id']);
        $res['invoice_payed'] = self::INVOICE_PAYED;
        if (App::$db->exec($query, $res) === false) {
            $executeMsgInvoice->showError();
            LogDriver::warning(App::$db->getErrors(), 3);
        } else {
            $executeMsgInvoice->showSuccess();
        }

        /**/
        return $resultSent;
    }

    /**
     * @param string $HttpMethod
     * @return array
     * @throws ConfigException
     */
    private static function generateBearer($HttpMethod = 'POST')
    {
        if (!App::$config->get('bearer_secret_key')) {
            throw new ConfigException('Config param bearer_secret_key is required');
        }
        $utc_timestamp = time();
        return [
            'hash' => md5(mb_strtoupper($HttpMethod) . $utc_timestamp . App::$config->get('bearer_secret_key')),
            'additional_header' => ['X-UTC-Timestamp: ' . $utc_timestamp],
        ];
    }

    /**
     * @param array $data
     * @return false|string
     * @throws ConfigException
     */
    public static function getPdfInvoice(array $data)
    {
        $executeMsg = LogDriver::executingMessage("Requesting pdf for invoice_id=[warn]{$data[0]['invoice_id']}[/warn]", 2);

        /* request array for form json-request */
        $request_data = [
            /* client data */
            'payer_full_name' => !empty(trim($data[0]['client_company_name']))
                ? trim($data[0]['client_company_name'])
                : "{$data[0]['client_second_name']} {$data[0]['client_first_name']}",
            'payer_addr_1' => $data[0]['client_street'],
            'payer_addr_2' => "{$data[0]['client_postcode']} {$data[0]['client_city']}",
            'payer_country' => $data[0]['client_country'] ? $data[0]['client_country'] : 'CH',

            /* common bill data */
            'cur_date' => $data[0]['invoice_date'], // "3. März 2021",
            'bill_num' => "{$data[0]['invoice_id']}", // "2021-5001504",
            'bill_setup_date' => $data[0]['invoice_date'], //"19. Januar 2021",
            'bill_KontaktID' => "WL-0045133",
            'bill_additional_info' => "Rechnungsnummer: {$data[0]['invoice_id']}",
            'bill_currency' => "CHF",

            // not sure that is necessarily to use in pdf
            // (will be sent as request field and on that side can decide use or not)
            'bill_lang' => $data[0]['invoice_lang'],

            /* bill list products */
            //'listItems' => [],
        ];

        /* bill list products */
        foreach ($data as $product) {
            $request_data['listItems'][] = [
                'name' => $product['product_name'],
                'period' => "{$product['period_start']} - {$product['period_end']}",
                'jr' => "Jr",
                'count' => intval($product['product_count']),
                'cost' => doubleval($product['product_amount']),
                'tax' => doubleval($product['product_tax']),
            ];
        }

        /* company data */
        if (!App::$config->get('company_data')) {
            throw new ConfigException('Config param company_data is required');
        }
        $request_data = array_merge(App::$config->get('company_data', []), $request_data);
        //dd(json_encode($request_data));

        /* request pdf from another server */
        if (!App::$config->get('url_pdf_receive')) {
            throw new ConfigException('Config param url_pdf_receive is required');
        }
        $Bearer = self::generateBearer();
        $response = WgetDriver::init()
            ->setBearerAutorisation($Bearer['hash'], $Bearer['additional_header'])
            ->asJson()
            ->post(App::$config->get('url_pdf_receive'), $request_data);

        if ($response->status() !== 200) {
            $executeMsg->showError();
            LogDriver::warning("Server return code {$response->status()}", 3);
            LogDriver::warning("Full answer from server:\n" . dumpIntoStr([
                    'request_data' => $request_data,
                    'headers' => $response->response_headers(),
                    'body' => $response->body(),
                ]), 4);
            return false;
        }
        $type = (new finfo(FILEINFO_MIME))->buffer($response->body());
        if (strrpos($type, 'pdf') === false) {
            $executeMsg->showError();
            LogDriver::warning("Server return not pdf data type. The type of response {$type}", 3);
            LogDriver::warning("Full answer from server:\n" . dumpIntoStr([
                    'request_data' => $request_data,
                    'headers' => $response->response_headers(),
                    'body' => $response->body(),
                ]), 4);
            return false;
        }

        $executeMsg->showSuccess();
        return $response->body();
        /* save file */
        /*
        if (!$response->save(App::$config->get('tmp_save_pdf_file'))) {
            return false;
        }
        return true;
        */
    }
}
