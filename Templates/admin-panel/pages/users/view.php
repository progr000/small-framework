<?php
/** @var Core\ViewDriver $view */
/** @var $user \Models\User */

$vars['title'] = 'Users';
?>
<div class="ad-panel-content active">
    <h2>Users</h2>
    <p>Info about user</p>

    <a href="<?= url("/admin-panel/users") ?>">&lt;&lt;&lt;Back</a>
    <table class="list-of-something">
        <tr><td>Id:</td><td><?= $user->id ?></td></tr>
        <tr><td>Name:</td><td><?= $user->username ?></td></tr>
        <tr><td>Role:</td><td><?= $user->role ?></td></tr>
    </table>

</div>