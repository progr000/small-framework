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
     * @return \Core\ResponseDriver|void
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

        //dd($request->route());

        /* here verify csrf */
        $last_valid_csrf_val = session('csrf', null);
        //$check_csrf_val_get  = cookie('CSRF-COOKIE', null);
        $check_csrf_val_post = $request->post('csrf', null);

        if (!$request->isGet()) {
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

        if (!$request->isAjax()) {
            $new_valid_csrf_val = uniqid('') . "-". md5(microtime().mt_rand(0,999999));
            //cookie()->make('CSRF-COOKIE', $new_valid_csrf_val);
            session(['csrf' => $new_valid_csrf_val]);
        }


//        if ($request->isGet()) {
//            if ($check_csrf_val_get === null && $last_valid_csrf_val === null) {
//                $new_valid_csrf_val = md5(time());
//                cookie()->make('CSRF-COOKIE', $new_valid_csrf_val);
//                session(['csrf' => $new_valid_csrf_val]);
//                return App::$response->goHome();
//            }
//            if ($check_csrf_val_get !== $last_valid_csrf_val) {
//                throw new HttpForbiddenException('CSRF-Validation failed');
//            }
//        }

    }
}