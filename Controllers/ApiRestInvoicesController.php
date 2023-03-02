<?php

namespace Controllers;

use Core\App;
use Core\ControllerDriver;
use Core\Exceptions\ConfigException;
use Core\Exceptions\NotImplementedException;
use Core\Interfaces\RestInterface;
use Core\LogDriver;
use Models\Invoice;
use Models\InvoiceProduct;
use Workers\MultiInvoiceWorker;

/**
 * RestController example
 */
class ApiRestInvoicesController extends ControllerDriver implements RestInterface
{
    /**
     * Get all invoices (list)
     */
    public function index()
    {
        return Invoice::findAll();
    }

    /**
     * Get invoice data with $id
     * @param int $id
     */
    public function view($id)
    {
        /* prepare var */
        $id = intval($id);

        /* return data */
        return [
            'invoice' => Invoice::findById($id),
            'products' => InvoiceProduct::find(['invoice_id' => $id]),
        ];
    }

    /**
     * Get PDF for invoice $id
     * @param $id
     * @return array|false|string
     */
    public function pdf($id)
    {
        /* prepare var */
        $id = intval($id);

        /* receiving data from DB */
        $query = "SELECT * 
                  FROM {{invoices}} AS I
                  INNER JOIN {{invoice_products}} AS P ON I.invoice_id = P.invoice_id
                  WHERE (I.invoice_id = :id)";
        $data = App::$db->getAll($query, ['id' => $id]);

        /* if empty sql result */
        if (empty($data) || !is_array($data)) {
            return [
                'status' => false,
                'errors' => "Invoice with invoice_id={$id} not found in database",
            ];
        }

        /* try to receive PDF */
        try {

            LogDriver::setVerboseLevel(-100);
            $invoice = MultiInvoiceWorker::getPdfInvoice($data);
            if (!$invoice) {
                return [
                    'status' => false,
                    'errors' => "Wrong format for invoice received from invoice server.",
                ];
            }
            App::$response->asFile(
                "Invoice-for-{$data[0]['first_name']}-{$data[0]['second_name']}.pdf",
                true,
                "application/pdf"
            );
            return $invoice;

        } catch (ConfigException $e) {
            return [
                'status' => false,
                'errors' => "Server not configured right.",
            ];
        }
    }

    /**
     * @inheritdoc
     * @param int $id
     * @throws NotImplementedException
     */
    public function edit($id)
    {
        throw new NotImplementedException('Method not implemented', 405);
    }

    /**
     * @inheritdoc
     * @param int $id
     * @throws NotImplementedException
     */
    public function update($id)
    {
        throw new NotImplementedException('Method not implemented', 405);
    }

    /**
     * @inheritdoc
     * @throws NotImplementedException
     */
    public function create()
    {
        throw new NotImplementedException('Method not implemented', 405);
    }

    /**
     * @inheritdoc
     * @throws NotImplementedException
     */
    public function store()
    {
        throw new NotImplementedException('Method not implemented', 405);
    }

    /**
     * @inheritdoc
     * @param int $id
     * @throws NotImplementedException
     */
    public function delete($id)
    {
        throw new NotImplementedException('Method not implemented', 405);
    }
}