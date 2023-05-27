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
        'charset' => 'utf8',
    ],

    /* config params for database connection named as mysql-for-developing, you can create another new connections instead bellow */
    'mysql-for-developing' => [
        'dsn' => "mysql:host=mysql-for-developing;dbname=test;port=3306",
        'user' => "root",
        'password' => "mauFJcuf5dhRMQrjj",
        'table_prefix' => "tbl_",
        'charset' => 'utf8',
    ],

    'weblandAdmin' => [
        'dsn' => "sqlsrv:Server=176.9.103.55,1433;Database=WLAdmin",
        'user' => "SA",
        'password' => "jgf@Y%jH!dR86vmu",
        'table_prefix' => "",
        'charset' => 'utf8',
    ],

    'postgres-for-developing' => [
        'dsn' => "pgsql:host=postgres-for-developing;dbname=test;port=5432",
        'user' => "postgres",
        'password' => "secret",
        'table_prefix' => "",
        'charset' => 'utf8',
    ],
];
