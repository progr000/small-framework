<?php

namespace Middleware;

use Core\App;
use Core\Interfaces\MiddlewareInterface;
use Core\RequestDriver;
use Core\ResponseDriver;

class Localization implements MiddlewareInterface
{
    /**
     * @param RequestDriver $request
     * @param ResponseDriver $response
     * @return void
     */
    public function handleOnRequest(RequestDriver $request, ResponseDriver $response)
    {
        if (session()->has('locale')) {
            App::$locale = session('locale');
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
