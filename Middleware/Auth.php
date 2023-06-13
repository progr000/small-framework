<?php

namespace Middleware;

use Core\App;
use Core\RequestDriver;

/**
 * All routes used this middleware
 * will be allowed only if Debug mode is ON
 */
class Auth
{
    /**
     * @param RequestDriver $request
     * @return void
     */
    public function handle(RequestDriver $request)
    {
        if (!session('Auth')) {
            App::$response->redirect('/admin-panel/login');
        }
    }
}