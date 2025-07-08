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
class AllowOnlyWhitelistedIPs implements MiddlewareInterface
{
    /**
     * @param RequestDriver $request
     * @param ResponseDriver $response
     * @return void
     * @throws HttpForbiddenException
     */
    public function handleOnRequest(RequestDriver $request, ResponseDriver $response)
    {
        $IP = $request->ip();
        $WHITE_LISTED_IPS = config('WHITE_LISTED_IPS');
        if (gettype($WHITE_LISTED_IPS) !== 'array') {
            throw new HttpForbiddenException("Forbidden (expected an array IPs or subnets in config-var WHITE_LISTED_IPS)", 403);
        }
        if (is_array($WHITE_LISTED_IPS) && !$this->ipIsAllowed($IP, $WHITE_LISTED_IPS)) {
            throw new HttpForbiddenException("Forbidden (IP [{$IP}] is not allowed to access this page)", 403);
        }
    }

    /**
     * @param ResponseDriver $response
     * @return void
     */
    public function handleOnResponse(ResponseDriver $response)
    {
    }


    /**
     * Check if a given ip is in a network
     * @param string $ip
     * @param array $whitelistIp
     * @return boolean
     */
    private function ipIsAllowed($ip, $whitelistIp)
    {
        if (in_array($ip, $whitelistIp)) {
            return true;
        }

        foreach ($whitelistIp as $range) {
            if (strpos($range, '/') == false) {
                continue;
            }

            // $range is in IP/CIDR format e.g. 127.0.0.1/24
            list($range, $netmask) = explode('/', $range, 2);
            $range_decimal = ip2long($range);
            $ip_decimal = ip2long($ip);
            $wildcard_decimal = pow(2, (32 - $netmask)) - 1;
            $netmask_decimal = ~$wildcard_decimal;
            if (($ip_decimal & $netmask_decimal) == ($range_decimal & $netmask_decimal)) {
                return true;
            }
        }

        return false;
    }
}