<?php
/** @var Core\ViewDriver $view */
/** @var string $content */
/** @var array $vars */
//$menu = $view->renderView('layouts/menu', $vars);

$view->firstInCssStack('/css/simple-html/main.css');
$view->firstInJsStack([
    '/js/simple-html/jquery-3.6.3.min.js',
    '/js/simple-html/jquery.validate/jquery.validate.min.js',
    '/js/simple-html/jquery.validate/additional-methods.min.js',
    "/js/simple-html/jquery.validate/localization/messages_" . Core\App::$locale . ".js",
    '/js/simple-html/common-functions.js',
]);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="<?= csrf() ?>">
    <title>Simple html example<?= isset($vars['title']) ? " - {$vars['title']}" : "" ?></title>
    {%CSS-STACK}
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
                        $locales = config('localization->available-locales', []);
                        foreach ($locales as $k => $v) {
                            if (session('locale', config('localization->default-locale', 'en')) === $k) {
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

{%JS-STACK}

</body>
</html>