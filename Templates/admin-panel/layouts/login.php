<?php
/** @var Core\ViewDriver $view */
/** @var string $content */
/** @var array $vars */
?>
<!DOCTYPE html>
<html lang="<?= \Core\App::$locale ?>">
<head>
    <title><?= isset($vars['title']) ? $vars['title'] . " | " : "" ?>Admin-panel</title>
    <?= $view->renderView('layouts/css', $vars); ?>
</head>
<body>
    <?= $content ?>
</body>
</html>
