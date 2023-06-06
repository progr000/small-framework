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
        'dsn' => "mysql:host=mysql-for-developing;dbname=test;port=3306",
        'user' => "root",
        'password' => "mauFJcuf5dhRMQrjj",
        'table_prefix' => "tbl_",
        'charset' => 'utf8',
    ],

    'mssql-for-developing' => [
        'dsn' => "sqlsrv:Server=mssql-for-developing,1433;Database=test",
        'user' => "SA",
        'password' => "Secret1234",
        'table_prefix' => "tbl_",
        'charset' => 'utf8',
    ],

    'postgres-for-developing' => [
        'dsn' => "pgsql:host=postgres-for-developing;dbname=test;port=5432",
        'user' => "postgres",
        'password' => "secret",
        'table_prefix' => "tbl_",
        'charset' => 'utf8',
    ],
];
