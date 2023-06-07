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
        if (session()->has('locale')) {
            App::$locale = session('locale');
        }
    }
}
