<?php

namespace Middleware;

use Core\App;
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
        $key = App::$config->get('Trusted-Proxies-X-Forwarded-Prefix', 'no-config');
        $check = md5($ua . '---' . $key . '---' . $salt);
        if ($request->header('X-Forwarded-Prefix', 'no-header') === $check) {
            $request->setTrustProxies([$request->ip()]);
        }
        */

        if ($request->header('X-Forwarded-Hash', 'no-header') === App::$config->get('Trusted-Proxies-X-Forwarded-Hash', 'no-config')) {
            $request->setTrustProxies([$request->ip()]);
        }
    }
}