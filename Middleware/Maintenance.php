<?php

namespace Middleware;

use Core\Exceptions\MaintenanceException;
use Core\RequestDriver;

/**
 * All routes used this middleware
 * will be allowed only if Debug mode is ON
 */
class Maintenance
{
    /**
     * @param RequestDriver $request
     * @return void
     * @throws MaintenanceException
     */
    public function handle(RequestDriver $request)
    {
        if (defined('IS_UNDER_MAINTENANCE') && IS_UNDER_MAINTENANCE) {
            $ip = $request->ip();
            if (defined('MAINTENANCE_ACCESS_IPS') && !in_array($ip, MAINTENANCE_ACCESS_IPS)) {
                throw new MaintenanceException('Site is under maintenance now, please try late', 503);
            }
        }
    }
}