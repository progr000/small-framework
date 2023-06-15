<?php
/* you can put or move some params into local conf 'main-local.php' and they will be override current params above */
if (file_exists(__DIR__ . "/main-local.php")) {
    $local_conf = require_once(__DIR__ . "/main-local.php");
} else {
    $local_conf = [];
}

/* config data */
return array_merge([

    /* debug mode */
    'IS_DEBUG' => true,

    /* maintenance options */
    'IS_UNDER_MAINTENANCE' => true,
    'MAINTENANCE_ACCESS_IPS' => [
        '127.0.0.1',
        '172.22.0.1',
        '172.18.0.1',
        '172.26.0.1',
        '192.168.96.1',
    ],

    /* wget params */
    'IGNORE_SSL_ERRORS' => true, // if you planed sent request to the servers with wrong certificate need set to true

    /* cookie encrypt ket */
    'cookie-enc-key' => 'dfmBDfeow3ewcdsf323$%dDS*',

    /* routes */
    //'routes' => require_once('routes.php'),
    'routes' => array_merge(
        require_once('routes.php'),
        require_once('routes-examples.php')
    ),

    /* middleware which were applied to each (any) request */
    'global-middleware' => [
        Middleware\Maintenance::class,
        Middleware\VerifyCsrfToken::class,
        Middleware\TrustProxies::class,
        Middleware\Localization::class,
    ],

    /* database params (should return array of config for available databases) */
    'databases' => require_once('databases.php'),

    /* templates for ViewDriver */
    'template-path' => __DIR__ . '/../Templates/simple-html',
    'admin-template-path' => __DIR__ . '/../Templates/admin-panel',
    'minimize-plain-css-js' => true,

    /**/
    'localization' => require_once('localization.php'),

    /* log params */
    'logs' => require_once('logs.php'),

    /* BearerAuth secret-key */
    'api.api-storage-access-token' => "",

    /* for sign mail */
    'sendmail_cert_dir' => "",

], $local_conf);