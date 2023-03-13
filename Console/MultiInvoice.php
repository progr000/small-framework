<?php
namespace Console;

use Core\App;
use Core\ConsoleDriver;
use Core\Exceptions\ConfigException;
use Core\Exceptions\DbException;
use Core\LogDriver;
use Exception;
use Workers\MultiInvoiceWorker;


class MultiInvoice extends ConsoleDriver
{
    /** @var string[] */
    protected $available_params = [
        'send-first-time-invoices' => "\tSend invoices to the clients which do not receive first letter yet",
        'fill-db'                  => "\t\t\t\tFill out the table with data",
        '--set-for-the-date'       => "=yyyy-mm-dd\tFill out the table by invoices with this date, actual only with --exec-fill-db",
        '--web-version-help'       => "\t\tShow how you can use this through http"
    ];

    /** @var MultiInvoiceWorker */
    protected $invoice;
    protected $for_the_date;

    /**
     * @return bool
     */
    public function init()
    {
        ignore_user_abort(true);
        LogDriver::setVerboseLevel($this->verbose_level);
        $this->invoice = new MultiInvoiceWorker();
        return true;
    }

    /**
     * Function for prepare and validate variables and environment
     * before someMethod will be run by starter.
     * @param array $actions
     * @return bool
     * @throws DbException
     */
    public function validate(array $actions)
    {
        //dump($this->for_the_date);
        LogDriver::setLog(App::$config->get('logs->multiInvoiceWorker.validate.log'));

        if (IS_DEBUG) {
            LogDriver::error("\tWARNING: Debug mode is enabled now", 0);
            LogDriver::error("\tIn this mode next limitation:", 0);
            LogDriver::error("\tTotal select records with products: {" . App::$config->get('debug.limit_fill_db_query', 50) . "}", 0);
            LogDriver::error("\tSending email to debug-address: {" . App::$config->get('debug.sendmail_debug_email_instead_clients', 'undefined@undefined.undefined') . "}", 0);
            LogDriver::error("\n\n", 0);
        }

        if (!$this->invoice->checkTablesInstalled()) {
            LogDriver::error("The tables doesn't installed. Use Migration before.", 1);
            LogDriver::error("Process terminated.", 1);
            return false;
        }

        return true;
    }

    /**
     * Filling tables by invoices
     * @return void
     * @throws ConfigException
     * @throws DbException
     */
    protected function fillDb()
    {
        LogDriver::setLog(App::$config->get('logs->multiInvoiceWorker.fillInvoiceTable.log'));
        $this->invoice->fillInvoiceTable($this->for_the_date);
    }

    /**
     * Send first letter with invoice
     * @return void
     * @throws Exception
     */
    protected function sendFirstTimeInvoices()
    {
        LogDriver::setLog(App::$config->get('logs->multiInvoiceWorker.sendFirstMailForInvoices.log'));
        $this->invoice->sendFirstMailForInvoices();
    }

    /**
     * @return void
     */
    protected function webVersionHelp()
    {
        LogDriver::createMessage("\n")
            ->messageAppend("/admin/webland/console/web-console-runner.php?task=fill-db&-vv\n")
            ->messageAppend("/admin/webland/console/web-console-runner.php?task=fill-db&for-the-date=2002-03-05&-vvv\n")
            ->messageAppend("/admin/webland/console/web-console-runner.php?task=send-first-time-invoices&-vvvv\n")
            ->setType('warning')
            ->setLevel(0)
            ->show(false, false);
    }
}
