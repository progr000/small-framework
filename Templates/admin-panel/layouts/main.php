<?php
/** @var Core\ViewDriver $view */
/** @var string $content */
/** @var array $vars */

$view->firstInCssStack('/css/admin-panel/style.css');
$view->firstInJsStack('/js/simple-html/jquery-3.6.3.min.js');
?>
<!DOCTYPE html>
<html lang="<?= \Core\App::$locale ?>">
<head>
    <title><?= isset($vars['title']) ? $vars['title'] . " | " : "" ?>Admin-panel</title>
    {%CSS-STACK}
</head>
<body>
    <div class="ad-panel-container">

        <?= $view->renderView('layouts/flash-messages'); ?>

        <?= $view->renderView('layouts/menu', $vars); ?>

        <?= $content ?>

    </div>

    {%JS-STACK}
</body>
</html>
