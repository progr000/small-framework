<?php

namespace Middleware;

use Core\Interfaces\MiddlewareInterface;
use Core\RequestDriver;
use Core\ResponseDriver;

/**
 * Force answer as json
 */
class ResponseAsJson implements MiddlewareInterface
{
    /**
     * @param RequestDriver $request
     * @param ResponseDriver $response
     * @interitdoc
     * @return void
     */
    public function handleOnRequest(RequestDriver $request, ResponseDriver $response)
    {
        $response->asJson();
    }

    /**
     * @param ResponseDriver $response
     * @return void
     */
    public function handleOnResponse(ResponseDriver $response)
    {
    }
}