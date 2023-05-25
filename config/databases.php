<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | will be used as default in ActiveRecordDriver if another not set,
    | also this connection available by App::$db
    | Another db-connections available via App::$DbInstances['connection-name']
    |
    */
    'default-db-connection-name' => 'db-main',

    /* config params for default database */
    'db-main' => [
        'dsn' => "mysql:host=176.9.103.55;dbname=usr_web1_1;port=9007",
        'user' => "root",
        'password' => "jgf@Y%jH!dR86vmu",
        'table_prefix' => "tbl_",
    ],

    /* config params for database connection named as db-second, you can create anothe new connections instead bellow */
    'db-second' => [
        'dsn' => "mysql:host=mysql-for-developing;dbname=test;port=3306",
        'user' => "root",
        'password' => "mauFJcuf5dhRMQrjj",
        'table_prefix' => "tbl_",
    ],
];
