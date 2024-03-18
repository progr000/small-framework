<?php

namespace Controllers;

use Core\ControllerDriver;
use Core\DbDriver;
use Core\Exceptions\DbException;
use Core\Providers\RelationshipContainer;
use Models\Contact;
use Models\Content;
use Models\WHMCS\Invoice;

class MainController extends ControllerDriver
{
    /**
     * @throws DbException
     */
    public function __construct()
    {
        parent::__construct();
        Content::putIntoSessionAllContent();
    }

    /**
     * @return \Exception|string
     * @throws DbException
     */
    public function index()
    {
        return $this->render('pages/index');
    }

    /**
     * @return \Exception|string
     */
    public function contacts()
    {
        return $this->render('pages/contacts');
    }
}