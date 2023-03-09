<?php

namespace Middleware;

use Core\App;
use Core\Exceptions\HttpForbiddenException;
use Core\RequestDriver;

/**
 * Force check Bearer auth
 */
class allowOnlyWithBearerAuth
{
    /**
     * @param RequestDriver $request
     * @return void
     * @throws HttpForbiddenException
     */
    public function handle(RequestDriver $request)
    {
        //'Authorization: Basic '. base64_encode("user:password")
        //'Authorization: Bearer 9a241522df5299facdef7b0182e4b507'

        $timestamp = $request->header('X-Timestamp');
        $token_hash = $request->bearerToken();

        if (empty($timestamp) || empty($token_hash))
            throw new HttpForbiddenException('Forbidden (allowed only Bearer-Authorized)', 403);

        if ($token_hash !== md5(mb_strtoupper($request->method()) . $timestamp . App::$config->get('api.api-storage-access-token', uniqid('api.api-storage-access-token'))))
            throw new HttpForbiddenException('Forbidden (Bearer-Authorization failed, wrong token)', 403);
    }
}