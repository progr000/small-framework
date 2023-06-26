<?php
/** @var $view Core\ViewDriver */
/** @var $content string */
/** @var $vars array */

$view->firstInCssStack('/css/admin-panel/style.css');
?>
<!DOCTYPE html>
<html lang="<?= Core\App::$locale ?>">
<head>
    <title><?= isset($vars['title']) ? $vars['title'] . " | " : "" ?>Admin-panel</title>
    {%CSS-STACK}
</head>
<body>
    <?= $content ?>
</body>
</html>
