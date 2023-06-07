<?php
/** @var Core\ViewDriver $view */
/** @var string $content */
/** @var array $vars */
//$menu = $view->renderView('layouts/menu', $vars);

if (!isset($vars['js-stack']) || !is_array($vars['js-stack'])) {
    $vars['js-stack'] = [];
}
if (!isset($vars['css-stack']) || !is_array($vars['css-stack'])) {
    $vars['css-stack'] = [];
}
$vars['js-stack'] = array_merge([
    "/simple-html/js/jquery-3.6.3.min.js",
], $vars['js-stack']);
$vars['css-stack'] = array_merge([
    "/simple-html/css/main.css",
], $vars['css-stack']);


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
        <link rel="stylesheet" href="<?= $style ?><?= config('IS_DEBUG', false) ? '?v=' . $filemtime : '' ?>">
        <?php
    }
    ?>

</head>
<body>

<table class="layout">
    <tr>
        <td colspan="2" class="header">
            <table width="100%" class="header-inner">
                <tr>
                    <td width="98%"><?= __('Simple html example') ?><?= isset($vars['title']) ? " - {$vars['title']}" : "" ?></td>
                    <td class="lang">
                        <?php
                        $locales = config('localization', ['available-locales' => []])['available-locales'];
                        foreach ($locales as $k => $v) {
                            if (session('locale', config('localization', ['default-locale' => 'en'])['default-locale']) === $k) {
                                echo '<span>' . $v . '</span><br/>';
                            } else {
                                echo '<a href="/lang/' . $k . '">' . $v . '</a><br/>';
                            }
                        }
                        ?>
                    </td>
                </tr>
            </table>
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
    if (config('IS_DEBUG', false)) {
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
    <script src="<?= $script ?><?= config('IS_DEBUG', false) ? '?v=' . $filemtime : '' ?>"></script>
    <?php
}
?>

</body>
</html>