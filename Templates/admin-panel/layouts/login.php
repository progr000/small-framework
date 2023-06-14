<?php
/** @var Core\ViewDriver $view */
/** @var string $content */
/** @var array $vars */

$view->firstInCssStack('/css/admin-panel/style.css');
?>
<!DOCTYPE html>
<html lang="<?= \Core\App::$locale ?>">
<head>
    <title><?= isset($vars['title']) ? $vars['title'] . " | " : "" ?>Admin-panel</title>
    {%CSS-STACK}
</head>
<body>
    <?= $content ?>
</body>
</html>
