<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Set here what driver for cache you want to use
    |--------------------------------------------------------------------------
    |
    | null - this driver doesn't cache anything, but you can use it as plug for debug without cache
    | session - this driver use php-session mechanism
    | file - this driver use filesystem
    | memcache - this driver use memcache server
    |
    */
    'driver' => 'session',

    /* credentials for null-driver (can be empty) */
    'null' => [],

    /* credentials for session-driver (can be empty) */
    /* important: this driver not suitable for work with console scripts ($_SESSION doesn't exist in console) */
    'session' => [],

    /* credentials for file-driver (store_dir should be defined and has rw-access for write for store data) */
    'file' => [
        'store_dir' => '/tmp/small-framework-file-cache-driver'
    ],

    /* credential for memcached-driver (you can add several servers) */
    'memcached' => [
        ['server' => 'whm-memcached','port' => '11211'],
        // ['server' => 'server-2','port' => 'port-2'],
        // ....
        // ['server' => 'server-N','port' => 'port-N'],
    ]
];
