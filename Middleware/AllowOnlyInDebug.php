<?php

namespace Middleware;

use Core\Exceptions\HttpForbiddenException;
use Core\Interfaces\MiddlewareInterface;
use Core\RequestDriver;
use Core\ResponseDriver;

/**
 * All routes used this middleware
 * will be allowed only if Debug mode is ON
 */
class AllowOnlyInDebug implements MiddlewareInterface
{
    /**
     * @param RequestDriver $request
     * @param ResponseDriver $response
     * @return void
     * @throws HttpForbiddenException
     */
    public function handleOnRequest(RequestDriver $request, ResponseDriver $response)
    {
        if (!config('IS_DEBUG', false)) {
            throw new HttpForbiddenException('Forbidden (allowed only in debug mode)', 403);
            //App::$response->redirect(App::$route->getRoute());
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