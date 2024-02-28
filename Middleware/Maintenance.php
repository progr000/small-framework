<?php

namespace Middleware;

use Core\Exceptions\MaintenanceException;
use Core\Interfaces\MiddlewareInterface;
use Core\RequestDriver;
use Core\ResponseDriver;

/**
 * For on/off maintenance mode
 */
class Maintenance implements MiddlewareInterface
{
    /**
     * @param RequestDriver $request
     * @param ResponseDriver $response
     * @return void
     * @throws MaintenanceException
     */
    public function handleOnRequest(RequestDriver $request, ResponseDriver $response)
    {
        if (config('IS_UNDER_MAINTENANCE', false)) {
            $ip = $request->ip();
            if (!in_array($ip, config('MAINTENANCE_ACCESS_IPS', []))) {
                throw new MaintenanceException('Site is under maintenance now, please try late', 503);
            }
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