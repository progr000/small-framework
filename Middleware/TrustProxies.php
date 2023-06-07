<?php

namespace Middleware;

use Core\RequestDriver;

/**
 * All routes used this middleware
 * will be allowed only if Debug mode is ON
 */
class TrustProxies
{
    /**
     * @param RequestDriver $request
     * @return void
     */
    public function handle(RequestDriver $request)
    {
        /*
        // for encrypted x-header-prefix
        $ua = $request->userAgent();
        $salt = $request->header('X-Forwarded-Salt', '');
        $key = config('Trusted-Proxies-X-Forwarded-Prefix', 'no-config');
        $check = md5($ua . '---' . $key . '---' . $salt);
        if ($request->header('X-Forwarded-Prefix', 'no-header') === $check) {
            $request->setTrustProxies([$request->ip()]);
        }
        */

        if ($request->header('X-Forwarded-Hash', 'no-header') === config('Trusted-Proxies-X-Forwarded-Hash', 'no-config')) {
            $request->setTrustProxies([$request->ip()]);
        }
    }
}