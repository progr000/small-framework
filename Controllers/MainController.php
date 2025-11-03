<?php

namespace Controllers;

use Core\App;
use Core\ControllerDriver;
use Maksym\Db\Exceptions\DbException;
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
        //var_dump(App::$cookie->set('test-cookie', 'test-value'));
        //var_dump(App::$cookie->get('test-cookie'));
        var_dump(App::$cookie->all());
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