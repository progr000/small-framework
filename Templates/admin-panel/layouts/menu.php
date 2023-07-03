<?php
/** @var $view Core\ViewDriver */
/** @var $vars array */

$menu_items = [
    '/admin-panel/dashboard' => __('Dashboard'),
    '/admin-panel/change-password' => __('Change password'),
    '/admin-panel/contents' => __('Content management'),
    '/admin-panel/contacts' => __('Messages'),
    '/admin-panel/users' => __('Users'),
    '/admin-panel/backup-database' => __('Database backup'),
    '/admin-panel/web-console' => __('Web-Console'),
    '/admin-panel/phpinfo' => __('PhpInfo'),
];
?>
<div class="ad-panel-tabs">
    <?php
    foreach ($menu_items as $url => $name) {
        /**/
        if (Core\App::$request->route() === $url) {
            $active = 'active';
        } else {
            $active = '';
        }
        ?>
        <div class="ad-panel-tab <?= $active ?>"><a href="<?= url($url) ?>"><?= $name ?></a></div>
        <?php
    }
    ?>
    <div class="ad-panel-tab logout"><a href="<?= url('/admin-panel/logout') ?>"><?= __('Logout') ?></a></div>

    <?= $view->renderView('layouts/lang-switcher') ?>

</div>
