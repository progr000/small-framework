<?php

namespace Middleware;

use Core\Exceptions\HttpForbiddenException;
use Core\Interfaces\MiddlewareInterface;
use Core\RequestDriver;
use Core\ResponseDriver;

/**
 * Force check Bearer auth
 */
class AllowOnlyWithBearerAuth implements MiddlewareInterface
{
    /**
     * @param RequestDriver $request
     * @param ResponseDriver $response
     * @return void
     * @throws HttpForbiddenException
     */
    public function handleOnRequest(RequestDriver $request, ResponseDriver $response)
    {
        //'Authorization: Basic '. base64_encode("user:password")
        //'Authorization: Bearer 9a241522df5299facdef7b0182e4b507'

        $x_utc_timestamp = $request->header('X-UTC-Timestamp');
        $token_hash = $request->bearerToken();

        /* check that headers are present */
        if (empty($x_utc_timestamp) || empty($token_hash))
            throw new HttpForbiddenException('Forbidden (allowed only Bearer-Authorized)', 403);

        /* check that $x_utc_timestamp is not in the future or in the past +-30sek */
        $current_utc_timestamp = time();
        if (intval($x_utc_timestamp) > $current_utc_timestamp + 30) {
            throw new HttpForbiddenException('Forbidden (Bearer-Authorization failed, your X-UTC-Timestamp is too far in the future)', 403);
        }
        if (intval($x_utc_timestamp) < $current_utc_timestamp - 30) {
            throw new HttpForbiddenException('Forbidden (Bearer-Authorization failed, your X-UTC-Timestamp is too far in the past)', 403);
        }

        /* check that the token-hash from incoming header is equal the hash that we generate from our api.api-storage-access-token by determined rule */
        if ($token_hash !== md5(mb_strtoupper($request->method()) . $x_utc_timestamp . config('api.api-storage-access-token', uniqid('api.api-storage-access-token'))))
            throw new HttpForbiddenException('Forbidden (Bearer-Authorization failed, wrong token)', 403);
    }

    /**
     * @param ResponseDriver $response
     * @return void
     */
    public function handleOnResponse(ResponseDriver $response)
    {
    }
}