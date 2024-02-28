<?php

namespace Middleware;

use Core\App;
use Core\Interfaces\MiddlewareInterface;
use Core\RequestDriver;
use Core\ResponseDriver;

/**
 * All routes used this middleware
 * will be allowed only if Debug mode is ON
 */
class Auth implements MiddlewareInterface
{
    /**
     * @param RequestDriver $request
     * @param ResponseDriver $response
     * @return void
     */
    public function handleOnRequest(RequestDriver $request, ResponseDriver $response)
    {
        if (!session('Auth')) {
            App::$response->redirect(url('/admin-panel/login'));
        }
    }

    /**
     * @param ResponseDriver $response
     * @return void
     */
    public function handleOnResponse(ResponseDriver $response)
    {
    }
}