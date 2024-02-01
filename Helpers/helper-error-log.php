<?php

if (!function_exists('hardSetErrorHandler')) {
    /**
     * @return void
     */
    function hardSetErrorHandler()
    {
        $GLOBALS['hardSetErrorHandler'] = true;
        ini_set('display_errors', 1);
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            var_dump($errno, $errstr, $errfile, $errline);
        });
    }
}
