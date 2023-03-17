<?php
return [

    /* hello everyone */
    '/hello(?:/?|/(.*))' => [Controllers\MainController::class, 'hello', /*'post'*/],
    '/some-examples(?:(?:/)(.*))?' => [Controllers\MainController::class, 'someExamples', /*'post'*/ 'middleware' => [
        //Middleware\TrustProxies::class,
    ]],

    /* debug */
    '/info(/.*)?' => [
        function(...$params) {
            dump($params, $_GET, \Core\App::$request->ip());
            phpinfo();
        },
        'middleware' => [
            Middleware\allowOnlyInDebug::class,
            //Middleware\allowOnlyWithBearerAuth::class,
        ],
    ],
    '/info2/(.*)/(.*)' => [
        function($p1, $p2) {
            dump($p1, $p2, $_GET);
            phpinfo();
        },
        //'method' => 'post',
        //'middleware' => Middleware\allowOnlyInDebug::class,
    ],
    '/echo(/.*)?' => function(...$params) {
        if (IS_DEBUG) {
            dump(file_get_contents('php://input'), $params, $_GET, $_POST);
        }
    },

    /*
     * rest-controller-example
     * for the rest controller available next routes
     * GET /controller-name/            - list items
     * GET /controller-name/intId       - view item
     * GET /controller-name/intId/view  - view item (alias for previous)
     * GET /controller-name/intId/edit  - show edit form for item
     * PUT /controller-name/intId       - update item
     * GET /controller-name/create      - show create form for item
     * POST /controller-name/           - create new item
     * DELETE /controller-name/intId    - delete item
     *
     * Also here we can use next route for ANY another actions (additional) for the rest-api that not described above
     * for example:
     * GET /controller-name/intId/any-your-action
     * POST /controller-name/intId/any-your-action
     * all this action will be executed if method presented in the controller
     * but rule for name method is any-your-action => anyYourAction(...$vars)
     * this action will be available by any http-method GET/POST/PUT...
     * (you can implement check for allowed http-method inside this method-function)
     */
    [Controllers\RestController::class], // automatic route path for rest by controller name will be created as /rest
    [Controllers\RestController::class, '/api/rest/', 'middleware' => [Middleware\allowOnlyWithBearerAuth::class]], // manual route path for rest as /api/rest

    /* Invoices rest + pdf */
    [Controllers\ApiRestInvoicesController::class, '/api/invoices/', 'middleware' => [
        Middleware\responseAsJson::class,
        Middleware\allowOnlyWithBearerAuth::class,
    ]],

    /* show how we can use /api/invoices */
    '/invoice-api-usage(?:/?|/(\d+)/?|/(\d+)/[a-z\-]{3,15})' => [Controllers\MainController::class, 'invoiceApiUsage', 'GET'],

    /*
     * document-root-index - must be the last,
     * you can split this regex and create
     * several strings with more simple regex.
     * For example this regex:
     *     '/invoice-api-usage(?:/?|/(\d+)/?|/(\d+)/[a-z\-]{3,15})'
     * is equivalent to these three:
     *     '/invoice-api-usage/?'
     *     '/invoice-api-usage/(\d+)/?'
     *     '/invoice-api-usage/(\d+)/[a-z\-]{3,15}/?'
     *
     * This regex bellow allow next urls:
     * /
     * /?any-get-params
     * /index
     * /index?any-get-params
     * /index/any/text/any/text/...?any-get-params
     * 'any/text/any/text/...' will be passed as first param into controller::method()
     * ?any-get-params - you can use as standard $_GET variables
     * /index.html
     * /index.htm
     */
    '(?:/?|/index(?:/?)|/index/([0-9]+)|/index(?:(?:/)(.*))?|/index\.htm(l?))' => [Controllers\MainController::class, 'index'],
];
