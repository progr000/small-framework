<?php
/* you can put or move some params into local conf 'main-local.php' and they will be override current params above */
if (file_exists(__DIR__ . "/main-local.php")) {
    $local_conf = require_once(__DIR__ . "/main-local.php");
} else {
    $local_conf = [];
}

/* config data */
return array_merge([

    /* routes */
    //'routes' => require_once('routes.php'),
    'routes' => array_merge(
        require_once('routes.php'),
        require_once('routes-examples.php')
    ),

    /* database params (should return array of config for available databases) */
    'databases' => require_once('databases.php'),

    /* caching driver and credentials */
    'caching' => require_once('caching.php'),

    /**/
    'localization' => require_once('localization.php'),

    /* log params */
    'logs' => require_once('logs.php'),

    /* company configuration */
    'company_data' => require_once('company_data.php'),

    /* mysqldump folder for backup */
    'backup-database-path' => __DIR__ . '/../logs/dump',

],
    require_once('maintenance.php'),
    require_once('site.php'),
    require_once('debug.php'),
    require_once('view.php'),
    require_once('middleware.php'),
    require_once('sendmail.php'),
    $local_conf
);