<?php
return [

    /* middleware which were applied to each (any) request */
    'global-middleware' => [
        Middleware\Maintenance::class,
        Middleware\VerifyCsrfToken::class,
        Middleware\TrustProxies::class,
        Middleware\Localization::class,
        Middleware\ResponseDebugPanel::class,
    ],

];