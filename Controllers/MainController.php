<?php

namespace Controllers;

use Core\ControllerDriver;
use Core\Exceptions\DbException;
use Models\Contact;
use Models\Content;

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
     */
    public function index()
    {
        dd(Contact::findOrFail(1)->order());
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