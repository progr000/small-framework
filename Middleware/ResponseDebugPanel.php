<?php

namespace Middleware;

use Core\App;
use Core\Interfaces\MiddlewareInterface;
use Core\RequestDriver;
use Core\ResponseDriver;

/**
 * Force answer as json
 */
class ResponseDebugPanel implements MiddlewareInterface
{
    /**
     * @param RequestDriver $request
     * @param ResponseDriver $response
     * @return void
     */
    public function handleOnRequest(RequestDriver $request, ResponseDriver $response)
    {
    }

    /**
     * @param ResponseDriver $response
     * @return void
     */
    public function handleOnResponse(ResponseDriver $response)
    {
        if (config('SHOW_DEBUG_PANEL', false) && config('IS_DEBUG', false) && $response->isHtml()) {
            /* if SHOW_DEBUG_PANEL=true and IS_DEBUG=true then will be showed special debug panel with all debug info */
            $response->setBody(
                str_replace(
                    "</body>",
                    App::$debug->showDebugPanel(['__DEBUG_DATA' => $response->getDebugData()]) . "</body>",
                    $response->getBody()
                )
            );
        } elseif (config('IS_DEBUG', false) && $response->isHtml()) {
            /* if SHOW_DEBUG_PANEL=false and IS_DEBUG=true then debug info will be showed before main page output (base-content) */
            $response->setBody($response->getDebugData() . $response->getBody());
        }
    }
}
