<?php

namespace Middleware;

use Core\Exceptions\HttpForbiddenException;
use Core\Interfaces\MiddlewareInterface;
use Core\RequestDriver;
use Core\ResponseDriver;
use Core\SessionDriver;

class VerifyCsrfToken implements MiddlewareInterface
{
    protected $except_routes_regex = [
        '~^/api/(.*)$~',
    ];

    /**
     * @param RequestDriver $request
     * @param ResponseDriver $response
     * @return void
     * @throws HttpForbiddenException
     */
    public function handleOnRequest(RequestDriver $request, ResponseDriver $response)
    {
        /* do not apply this middleware to except routes */
        foreach ($this->except_routes_regex as $v) {
            if (preg_match($v, $request->route())) {
                return;
            }
        }

        /**/
        $sess_csrf = SessionDriver::getInstance('csrf');
        if ($request->isGet()) {
            $sess_csrf->put(['previous_csrf' => $sess_csrf->get('csrf')]);
            $new_valid_csrf_val = uniqid('') . "-". md5(microtime().mt_rand(0,999999)) . $request->route();
            $sess_csrf->put(['csrf' => $new_valid_csrf_val]);
        }

        /* here verify csrf */
        if (!$request->isGet()) {
            $last_valid_csrf_val = $sess_csrf->get('csrf', null);
            $check_csrf_val_post = $request->all('csrf', null);
            if (!$last_valid_csrf_val) {
                // "csrf" on server is empty
                throw new HttpForbiddenException('CSRF-Validation failed (please, reload page and try again)');
            }
            if (!$check_csrf_val_post) {
                throw new HttpForbiddenException('CSRF-Validation failed (please, repair your html form and add hidden field &ltintput type="hidden" value="&lt;?= csrf() ?&gt;"&gt;)');
            }
            if ($check_csrf_val_post !== $last_valid_csrf_val) {
                // Server "csrf" value does not match with value that you sent
                throw new HttpForbiddenException('CSRF-Validation failed (please, reload page and try again)');
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
