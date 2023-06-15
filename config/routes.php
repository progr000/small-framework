<?php
return [
    /* language switch */
    '/language|lang/([a-zA-Z]{2})/?' => [
        function(...$params) {
            $locales = config('localization->available-locales', []);
            if (isset($locales[$params[0]])) {
                session(['locale' => $params[0]]);
            }
            return \Core\App::$response->goBack();
        }
    ],

    /* debug middleware example */
    '/info(/.*)?' => [
        function(...$params) {
            //dump($params, $_GET, \Core\App::$request->ip());
            phpinfo();
        },
        'middleware' => [
            Middleware\AllowOnlyInDebug::class,
        ],
    ],

    /* Login-Logout routes */
    '/admin-panel/login' => [Controllers\AdminPanel\LoginController::class, 'login'],
    '/admin-panel/logout' => [Controllers\AdminPanel\LoginController::class, 'logout'],

    /* Admin-Panel routes */
    '/admin-panel/phpinfo(?:/?)' => [Controllers\AdminPanel\AdminController::class, 'phpinfo', 'get'],
    [Controllers\AdminPanel\UsersController::class, 'prefix' => '/admin-panel/users/', 'middleware' => [Middleware\Auth::class]], // rest interface
    '/admin-panel/change-password(?:/?)' => [Controllers\AdminPanel\AdminController::class, 'changePassword'],
    '/admin-panel/web-console(?:/?)' => [Controllers\AdminPanel\AdminController::class, 'webConsole', 'get'],
    '/admin-panel(?:/index|/dashboard|)(?:/?)' => [Controllers\AdminPanel\AdminController::class, 'dashboard', 'get'],

    /* document-root-index - must be the last */
    '(?:/?|/index(?:/?)|/index/([0-9]+)|/index(?:(?:/)(.*))?|/index\.htm(l?))' => [Controllers\MainController::class, 'index', 'get'],
];
