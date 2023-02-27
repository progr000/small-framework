<?php

namespace Controllers;


use Core\App;

class Controller
{
    /**
     * Controller constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param string $url
     * @param int $status
     * @return \Core\ResponseDriver
     */
    protected function redirect($url, $status = 302)
    {
        return App::$response->redirect($url, $status);
    }
}