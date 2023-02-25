<?php

namespace Middleware;

use Core\App;
use Core\RequestDriver;

/**
 * Force answer as json
 */
class responseAsJson
{
    /**
     * @param RequestDriver $request
     * @return void
     */
    public function handle(RequestDriver $request)
    {
        App::$response->asJson();
    }
}