<?php

namespace Controllers;

use Core\ControllerDriver;
use Core\Exceptions\DbException;
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