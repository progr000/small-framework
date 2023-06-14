<?php
/** @var Core\ViewDriver $view */
/** @var string $content */
/** @var array $vars */
/** @var string $CSS_STACK */

$view->firstInCssStack('/css/admin-panel/style.css');
$view->firstInJsStack('/js/simple-html/jquery-3.6.3.min.js');
?>
<!DOCTYPE html>
<html lang="<?= \Core\App::$locale ?>">
<head>
    <title><?= isset($vars['title']) ? $vars['title'] . " | " : "" ?>Admin-panel</title>
    <?= $view->renderView('layouts/css', $vars); ?>
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
