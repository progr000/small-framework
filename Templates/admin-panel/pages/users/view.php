<?php
/** @var $view Core\ViewDriver */
/** @var $user Models\User */

$vars['title'] = __('User: {%name}', ['name' => $user->username]);
?>
<div class="ad-panel-content active">
    <h2><?= $vars['title'] ?></h2>
    <p><?= __('Info about user') ?></p>

    <a href="<?= url("/admin-panel/users") ?>">&lt;&lt;&lt; <?= __('Back') ?></a>
    <table class="list-of-something">
        <tr><td><?= __('Id') ?>:</td><td><?= $user->id ?></td></tr>
        <tr><td><?= __('Name') ?>:</td><td><?= $user->username ?></td></tr>
        <tr><td><?= __('Role') ?>:</td><td><?= Models\User::getRoles($user->role) ?></td></tr>
    </table>

</div>