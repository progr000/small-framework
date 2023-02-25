<?php
/** Enter-point for http-app running */

try {
    /** connect autoload */
    require_once(__DIR__ . '/../vendor/autoload.php');

    /** for web-app disable in LogDriver ob_end_flush()  */
    Core\LogDriver::$execute_ob_end_flush = false;

    /** init and run application */
    Core\App::init(__DIR__ . "/../config")->run();

} catch (Exception $e) {
    /** if something wrong */
    header(Core\ResponseDriver::getHeaderForResponseStatus(500));
    echo $e->getMessage();
    die();
}
