<?php
/** @var Core\ViewDriver $view */
/** @var string $content */
/** @var array $vars */
//$menu = $view->renderView('layouts/menu', $vars);

$vars['css-stack'][] = "/css/main.css";
$vars['js-stack'][] = "/js/jquery-3.6.3.min.js";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Simple html example<?= isset($vars['title']) ? " - {$vars['title']}" : "" ?></title>

    <?php
    foreach ($vars['css-stack'] as $style) {
        $filemtime = file_exists(__WWW_DIR__ . $style)
            ? filemtime(__WWW_DIR__ . $style)
            : time();
        ?>
        <link rel="stylesheet" href="<?= $style ?><?= IS_DEBUG ? '?v=' . $filemtime : '' ?>">
        <?php
    }
    ?>

</head>
<body>

<table class="layout">
    <tr>
        <td colspan="2" class="header">
            Simple html example<?= isset($vars['title']) ? " - {$vars['title']}" : "" ?>
        </td>
    </tr>
    <tr>
        <td>


            <?= $content ?>


        </td>

        <td class="sidebar" style="width: 300px;">
            <div class="sidebarHeader">Menu</div>

            <?= $view->renderView('layouts/menu', $vars); ?>

        </td>
    </tr>
    <tr>
        <td class="footer" colspan="2">Copyright (c) Maks</td>
    </tr>
    <?php
    if (IS_DEBUG) {
        ?>
        <tr>
            <td class="footer" colspan="2">
                DEBUG-Console:<br>
                <div style="text-align:left; background-color: #cccccc; width: 100%; max-height: 200px !important; overflow: auto;">%%%DEBUG-DATA%%%</div>
            </td>
        </tr>
        <?php
    }
    ?>
</table>

<?php
foreach ($vars['js-stack'] as $script) {
    $filemtime = file_exists(__WWW_DIR__ . $script)
        ? filemtime(__WWW_DIR__ . $script)
        : time();
    ?>
    <script src="<?= $script ?><?= IS_DEBUG ? '?v=' . $filemtime : '' ?>"></script>
    <?php
}
?>

</body>
</html>