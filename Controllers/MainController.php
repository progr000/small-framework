<?php

namespace Controllers;

use Core\ControllerDriver;

class MainController extends ControllerDriver
{
    /**
     * @return \Exception|string
     */
    public function index()
    {
        return $this->render('main/index');
    }
}