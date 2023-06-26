<?php
$menu_items = [
    '/admin-panel/dashboard' => 'Dashboard',
    '/admin-panel/web-console' => 'Web-Console',
    '/admin-panel/change-password' => 'Change Password',
    '/admin-panel/users' => 'Users',
    '/admin-panel/phpinfo' => 'PhpInfo',
    '/admin-panel/logout' => 'Logout',
];
?>
<div class="ad-panel-tabs">
    <?php
    foreach ($menu_items as $url => $name) {
        if (Core\App::$request->route() === $url) {
            $active = 'active';
        } else {
            $active = '';
        }
        ?>
        <div class="ad-panel-tab <?= $active ?>"><a href="<?= $url ?>"><?= $name ?></a></div>
        <?php
    }
    ?>
</div>
