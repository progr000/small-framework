<?php
/* debug mode */
const IS_DEBUG = true;
const IS_UNDER_MAINTENANCE = true;
const MAINTENANCE_ACCESS_IPS = [
    '127.0.0.1',
    '172.22.0.1',
    '172.18.0.1',
];

/* config data */
return [
    /* wget params */
    'IGNORE_SSL_ERRORS' => true, // if you planed sent request to the servers with wrong certificate need set to true

    /* routes */
    'routes' => require_once('routes.php'),
    /* middleware which were applied to each (any) request */
    'global-middleware' => [
        Middleware\TrustProxies::class,
        Middleware\Maintenance::class,
    ],

    /* database params */
//    'db' => [
//        'dsn' => "",
//        'user' => "",
//        'password' => "",
//        'table_prefix' => "tbl_",
//    ],

    /* templates for ViewDriver */
    'template-path' => __DIR__ . '/../Templates/simple-html',

    /* log params */
    'logs' => require_once('logs.php'),

    /* BearerAuth secret-key */
    'api.api-storage-access-token' => "",
];