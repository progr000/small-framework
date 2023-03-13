<?php
/** Enter-point for http-app running */

/** base www dir */
const __WWW_DIR__ = __DIR__;

/** begin */
try {

    /** connect autoload */
    require_once(__DIR__ . '/../vendor/autoload.php');

    /** for web-app disable in LogDriver ob_end_flush()  */
    Core\LogDriver::$execute_ob_end_flush = false;

    /** init and run application */
    Core\App::init(__DIR__ . "/../config")->run();

} catch (Core\Exceptions\MaintenanceException $e) {
    /** if something wrong */
    header(Core\ResponseDriver::getHeaderForResponseStatus($e->getCode()));
    echo '<html lang="en"><body><div style="width: 100%; text-align: center; padding-top: 100px; color: #9a1a00; font-size: 5em;">' . $e->getMessage() . '</div></body></html>';
    die();
} catch (Exception $e) {
    /** if something wrong */
    header(Core\ResponseDriver::getHeaderForResponseStatus($e->getCode()));
    echo $e->getMessage();
    die();
}
