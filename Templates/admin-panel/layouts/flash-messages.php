<?php
/** @var $view Core\ViewDriver */

$view->putInCssStack(minimize(Services\FlashMessages::getDefaultCss()));
$view->putInJsStack(minimize(Services\FlashMessages::getDefaultJs()));

echo Services\FlashMessages::getMessageAsHtm();
