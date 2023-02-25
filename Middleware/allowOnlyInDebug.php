<?php

namespace Middleware;

use Core\App;
use Core\Exceptions\HttpForbiddenException;
use Core\RequestDriver;

/**
 * All routes used this middleware
 * will be allowed only if Debug mode is ON
 */
class allowOnlyInDebug
{
    /**
     * @param RequestDriver $request
     * @return void
     * @throws HttpForbiddenException
     */
    public function handle(RequestDriver $request)
    {
        if (!IS_DEBUG) {
            throw new HttpForbiddenException('Forbidden (allowed only in debug mode)', 403);
            //App::$response->redirect(App::$route->getRoute());
        }

    }
}