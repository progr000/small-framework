<?php
/* debug mode */
const IS_DEBUG = true;

return [
    /* wget params */
    'IGNORE_SSL_ERRORS' => true, // if you planed sent request to the servers with wrong certificate need set to true

    /* routes */
    'routes' => require_once('routes.php'),

    /* database params */
    'db' => [
        'dsn' => "",
        'user' => "",
        'password' => "",
        'table_prefix' => "tbl_",
    ],

    /* templates for ViewDriver */
    'templatePath' => __DIR__ . '/../Templates/simple-html',

    /* log params */
    'logs' => require_once('logs.php'),

    /* BearerAuth secret-key */
    'api.api-storage-access-token' => "",
];