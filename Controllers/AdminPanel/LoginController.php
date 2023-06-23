<?php

namespace Controllers\AdminPanel;

use Core\RequestDriver;
use Models\User;
use Requests\LoginRequest;

class LoginController extends _MainController
{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->layout = "layouts/login";
    }

    /**
     * @param RequestDriver $r
     * @return \Core\ResponseDriver|\Exception|string
     */
    public function login(RequestDriver $r)
    {
        if (session('Auth')) {
            return $this->redirect(url('/admin-panel/dashboard'));
        }
        if ($r->isPost()) {
            $r = new LoginRequest();
            return $this->redirect(url('/admin-panel/dashboard'));
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
        return $this->redirect(url('/admin-panel/login'));
    }
}