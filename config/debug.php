<?php
return [

    /* handler 404 */
    'OWN_404_HANDLER' => true, // if this framework used as part of another project, you should set this parameter to false

    /* debug mode */
    'IS_DEBUG' => true,

    /* Debug panel */
    'SHOW_DEBUG_PANEL' => true,
    /*
    | Can be implemented logging or showing in html
    | You can develop your own package and then include it via composer (see Core\Interfaces\DebugPanelDriverInterface)
    | Example: https://packagist.org/packages/maksym/debug-panel
    */
    //'DebugDriver' => null,
    'DebugDriver' => 'Maksym\\DebugPanel\\DebugPanelDriver',

    /* php errors configuration */
    'error_reporting' => E_ALL,
    'display_errors' => 1,
    // if error_handler is null then will be used default, but you can put callable here
    //'error_handler' => null,
    'error_handler' => function ($errno, $errstr, $errfile, $errline) {
        set_debug_data('phpErrors', [0 =>[
            'errno' => $errno,
            'errstr' => $errstr,
            'errfile' => $errfile,
            'errline' => $errline,
        ]]);
        //echo "<pre>"; dump($errno, $errstr, $errfile, $errline); echo "</pre>";
    },
    'sql_error_handler' => function (Exception $e, $sql = "") {
        //if (config('IS_DEBUG', false)) {
        throw new Maksym\Db\Exceptions\DbException("DbDriver::exec: {$e->getMessage()}\n\n{$sql}\n", 500);
        //} else {
        //return false;
        //}
    },

];