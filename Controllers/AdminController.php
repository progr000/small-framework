<?php

namespace Controllers;

use Core\App;
use Core\ControllerDriver;
use Core\Exceptions\DbException;
use Core\RequestDriver;
use Models\User;
use Requests\LoginRequest;

class AdminController extends ControllerDriver
{
    /**
     *
     */
    public function __construct()
    {
        App::$config->set('template-path', config('admin-template-path'));
        $this->layout = "layouts/main";
    }

    /**
     * @param RequestDriver $r
     * @return \Core\ResponseDriver|\Exception|string
     */
    public function login(RequestDriver $r)
    {
        if (session('Auth')) {
            return $this->redirect('/admin-panel/index');
        }
        if ($r->isPost()) {
            $r = new LoginRequest();
            return $this->redirect('/admin-panel/index');
        } else {
            return $this->render('pages/login');
        }
    }

    /**
     * @return \Core\ResponseDriver
     */
    public function logout()
    {
        User::logout();
        return $this->redirect('/admin-panel/login');
    }

    /**
     * @return \Exception|string
     * @throws DbException
     */
    public function index()
    {
        return $this->render('pages/index', [
            'users' => User::find()->orderBy(['id' => 'ASC'])->get(),
        ]);
    }

}