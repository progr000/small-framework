<?php

namespace Middleware;

use Core\Exceptions\HttpForbiddenException;
use Core\RequestDriver;

class VerifyCsrfToken
{
    protected $except_routes_regex = [
        '~^/api/(.*)$~',
    ];

    /**
     * @param RequestDriver $request
     * @return void
     * @throws HttpForbiddenException
     */
    public function handle(RequestDriver $request)
    {
        /* do not apply this middleware to except routes */
        foreach ($this->except_routes_regex as $v) {
            if (preg_match($v, $request->route())) {
                return;
            }
        }

        /**/
        if ($request->isGet()) {
            session(['previous_csrf' => session('csrf', null)]);
            $new_valid_csrf_val = uniqid('') . "-". md5(microtime().mt_rand(0,999999)) . $request->route();
            session(['csrf' => $new_valid_csrf_val]);
        }

        /* here verify csrf */
        if ($request->isPost()) {
            $last_valid_csrf_val = session('csrf', null);
            $check_csrf_val_post = $request->post('csrf', null);
            if (!$last_valid_csrf_val) {
                throw new HttpForbiddenException('CSRF-Validation failed ("csrf" on server is empty)');
            }
            if (!$check_csrf_val_post) {
                throw new HttpForbiddenException('CSRF-Validation failed (you don\'t sent "csrf" field in your request)');
            }
            if ($check_csrf_val_post !== $last_valid_csrf_val) {
                throw new HttpForbiddenException('CSRF-Validation failed (Server "csrf" value does not match with value that you sent)');
            }
        }

    }
}