<?php
/** @var Core\ViewDriver $view */
/** @var string $content */
/** @var array $vars */
//$menu = $view->renderView('layouts/menu', $vars);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Simple html example<?= isset($vars['title']) ? " - {$vars['title']}" : "" ?></title>
    <style>
        .layout {
            width: 100%;
            max-width: 1024px;
            margin: auto;
            background-color: white;
            border-collapse: collapse;
        }

        .layout tr td {
            padding: 20px;
            vertical-align: top;
            border: solid 1px gray;
        }

        .header {
            font-size: 30px;
        }

        .footer {
            text-align: center;
        }

        .sidebarHeader {
            font-size: 20px;
        }

        .sidebar ul {
            padding-left: 20px;
        }

        a, a:visited {
            color: darkgreen;
        }
        a.selected {
            font-weight: bold;
            color: #0c1721;
        }
    </style>
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
<script>

</script>
</body>
</html>