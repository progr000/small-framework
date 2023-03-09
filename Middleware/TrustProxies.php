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
        if ($request->header('X-Forwarded-Prefix', 'no-header') === App::$config->get('Trusted-Proxies-X-Forwarded-Prefix', 'no-config')) {
            $request->setTrustProxies([$request->ip()]);
        }
    }
}