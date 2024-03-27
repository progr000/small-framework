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
            $tmp_current = explode('.', $ip);
            /**/
            $allowed_ips = config('MAINTENANCE_ACCESS_ALLOWED_IPS', []);
            $allow = false;
            foreach ($allowed_ips as $allowed_ip) {
                $d0 = false;
                $d1 = false;
                $d2 = false;
                $d3 = false;
                /**/
                $tmp_allowed = explode('.', $allowed_ip);
                if (!isset($tmp_allowed[1]) || $tmp_allowed[1] === '') { $tmp_allowed[1] = '*'; }
                if (!isset($tmp_allowed[2]) || $tmp_allowed[2] === '') { $tmp_allowed[2] = '*'; }
                if (!isset($tmp_allowed[3]) || $tmp_allowed[3] === '') { $tmp_allowed[3] = '*'; }
                /**/
                if ($tmp_allowed[0] === $tmp_current[0] || $tmp_allowed[0] === '*') {
                    $d0 = true;
                }
                if (isset($tmp_current[1]) && ($tmp_allowed[1] === $tmp_current[1] || $tmp_allowed[1] === '*')) {
                    $d1 = true;
                }
                if (isset($tmp_current[2]) && ($tmp_allowed[2] === $tmp_current[2] || $tmp_allowed[2] === '*')) {
                    $d2 = true;
                }
                if (isset($tmp_current[3]) && ($tmp_allowed[3] === $tmp_current[3] || $tmp_allowed[3] === '*')) {
                    $d3 = true;
                }
                /**/
                if ($d0 && $d1 && $d2 && $d3) {
                    $allow = true;
                    break;
                }
            }

            /**/
            if (!$allow) {
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