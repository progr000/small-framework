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
    'default-db-connection-name' => 'mysql-for-developing',

    /* config params for database connection named as mysql-for-developing, you can create another new connections instead bellow */
    'mysql-for-developing' => [
        'dsn' => "mysql:host=for-dev-mysql;dbname=test;port=3306",
        'user' => "root",
        'password' => "mauFJcuf5dhRMQrjj",
        'table_prefix' => "tbl_",
        'charset' => 'utf8',
    ],

//    'mssql-for-developing' => [
//        'dsn' => "sqlsrv:Server=for-dev-mssql,1433;Database=test;TrustServerCertificate=1",
//        'user' => "SA",
//        'password' => "Secret1234",
//        'table_prefix' => "tbl_",
//        'charset' => 'utf8',
//    ],
//
//    'postgres-for-developing' => [
//        'dsn' => "pgsql:host=for-dev-postgres;dbname=test;port=5432",
//        'user' => "postgres",
//        'password' => "secret",
//        'table_prefix' => "tbl_",
//        'charset' => 'utf8',
//    ],

    /**/
    'maria-db-whmcs' => [
        'dsn' => "mysql:host=whm-mariadb;dbname=whmcs;port=3306",
        'user' => 'whmcs-user',
        'password' => 'DYu8B+jCnFysb3D5',
        'table_prefix' => 'tbl',
        'charset' => 'utf8',
    ],

    /**/
    'sqlite-for-developing' => [
        'dsn' => "sqlite:/var/log/php/sqlite-for-developing.sq3",
        'user' => 'any',
        'password' => 'any',
        'table_prefix' => 'tbl_',
        'charset' => 'utf8',
    ],
];
