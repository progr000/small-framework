<?php
/* debug mode */
const IS_DEBUG = true;

/* you can put or move some params into local conf 'main-local.php' and they will be override current params above */
if (file_exists(__DIR__ . "/main-local.php")) {
    $local_conf = require_once(__DIR__ . "/main-local.php");
} else {
    $local_conf = [];
}

/* config data */
return array_merge([

    /* maintenance options */
    'IS_UNDER_MAINTENANCE' => false,
    'MAINTENANCE_ACCESS_IPS' => [
        '127.0.0.1',
        '172.22.0.1',
        '172.18.0.1',
        '172.26.0.1',
    ],

    /* wget params */
    'IGNORE_SSL_ERRORS' => true, // if you planed sent request to the servers with wrong certificate need set to true

    /* routes */
    'routes' => require_once('routes.php'),
    /* middleware which were applied to each (any) request */
    'global-middleware' => [
        Middleware\TrustProxies::class,
        Middleware\Maintenance::class,
    ],

    /* database params (should return array of config for available databases) */
    'databases' => require_once('databases.php'),

    /* templates for ViewDriver */
    'template-path' => __DIR__ . '/../Templates/simple-html',

    /* log params */
    'logs' => require_once('logs.php'),

    /* BearerAuth secret-key */
    'api.api-storage-access-token' => "",

], $local_conf);