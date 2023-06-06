<?php

namespace Middleware;

use Core\App;
use Core\RequestDriver;

class Localization
{
    /**
     * @param RequestDriver $request
     * @return void
     */
    public function handle(RequestDriver $request)
    {
        //if (Session::has('locale')) {
        if (isset($_SESSION['app']['locale'])) {
            App::$locale = $_SESSION['app']['locale']; //Session::get('locale');
        }
    }
}
