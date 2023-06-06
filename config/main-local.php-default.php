<?php
/* rename this file to main-local.php to include it in config */
/* you can put or move some params into local conf 'main-local.php' and they will be override current params above */
return [
    /* (you can include any file to structured your config) */
    //'company_data' => require_once('company_data.php'),

    /* BearerAuth secret-key */
    'api.api-storage-access-token' => "a1b1c1d1e1-d-d-d-d",

    /* Prefix that we wait from proxies in header=X-Forwarded-Prefix to count them as trusted */
    'Trusted-Proxies-X-Forwarded-Hash' => "some-hash-key",
];
