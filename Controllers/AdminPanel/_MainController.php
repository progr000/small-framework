<?php

namespace Controllers\AdminPanel;

use Core\App;
use Core\ControllerDriver;

class _MainController extends ControllerDriver
{
    /**
     *
     */
    public function __construct()
    {
        /* change layouts global for all methods in this controller */
        App::$config->set('template-path', config('admin-template-path'));
        $this->layout = "layouts/main";
    }
}