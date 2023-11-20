<?php

namespace Controllers;

use Core\ControllerDriver;
use Core\DbDriver;
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
     * @throws DbException
     */
    public function index()
    {
        //dd(DbDriver::getInstance('postgres-for-developing')->exec("SELECT version()")->fetchAll());
        //dd(Contact::findOrFail(1)->order());
        //Contact::find()->where('1')->all();
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