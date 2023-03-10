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

        $x_utc_timestamp = $request->header('X-UTC-Timestamp');
        $token_hash = $request->bearerToken();

        /* check that headers are present */
        if (empty($x_utc_timestamp) || empty($token_hash))
            throw new HttpForbiddenException('Forbidden (allowed only Bearer-Authorized)', 403);

        /* check that $x_utc_timestamp is not in the future or in the past +-30sek */
        $current_utc_timestamp = strtotime(gmdate("Y-m-d  H:i:s"));
        if (intval($x_utc_timestamp) > intval($current_utc_timestamp)+30) {
            throw new HttpForbiddenException('Forbidden (Bearer-Authorization failed, your X-UTC-Timestamp is to far in the future)', 403);
        }
        if (intval($x_utc_timestamp) < intval($current_utc_timestamp)-30) {
            throw new HttpForbiddenException('Forbidden (Bearer-Authorization failed, your X-UTC-Timestamp is to far in the past)', 403);
        }

        /* check that the token-hash from incoming header is equal the hash that we generate from our api.api-storage-access-token by determined rule */
        if ($token_hash !== md5(mb_strtoupper($request->method()) . $x_utc_timestamp . App::$config->get('api.api-storage-access-token', uniqid('api.api-storage-access-token'))))
            throw new HttpForbiddenException('Forbidden (Bearer-Authorization failed, wrong token)', 403);
    }
}