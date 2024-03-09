<?php
return [

    /* handler 404 */
    'OWN_404_HANDLER' => false, // if this framework used as part of another project, you should set this parameter to false
    /* wget params */
    'IGNORE_SSL_ERRORS' => true, // if you planed sent request to the servers with wrong certificate need set to true


    /* debug mode */
    'IS_DEBUG' => true,
    'SHOW_DEBUG_PANEL' => true,
    'error_reporting' => E_ALL,
    'display_errors' => 1,
    // if error_handler is null then will be used default, but you can put callable here
    'error_handler' => null,
    'sql_error_handler' => function (Exception $e, $sql) {
        //if (config('IS_DEBUG', false)) {
            throw new Core\Exceptions\DbException(get_class($this) . "::exec: {$e->getMessage()}\n\n{$sql}\n", 500);
        //} else {
            //return false;
        //}
    },

];