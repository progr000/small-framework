<?php
return [
    /* maintenance options */
    'IS_UNDER_MAINTENANCE' => false,
    'MAINTENANCE_MESSAGE' => 'Site is under maintenance now,<br/>please try again in few minutes.<br/>', // . date('Y-m-d H:i:s'),
    'MAINTENANCE_ACCESS_ALLOWED_IPS' => [
        '127.*',
        //'172.20.0.1',
        //'192.168.96.1',
        //'172.',
        //'172.*',
        //'172.*.*.*',
        //'172.19.*.*',
        //'172.19.0.*',
        //'172.19.*',
    ],

];
