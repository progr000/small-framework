<?php
/** @var Core\ViewDriver $view */
/** @var $users \Models\User[] */

$vars['title'] = 'Panel';
$vars['js-stack'][] = '/js/admin-panel/init-tabs.js';
?>
<div class="ad-panel-container">

    <div class="ad-panel-tabs">
        <div class="ad-panel-tab active" data-tab="panel1">Password</div>
        <div class="ad-panel-tab" data-tab="panel2">Users</div>
        <div class="ad-panel-tab"><a href="/admin-panel/logout">Logout</a></div>
    </div>

    <div id="panel1" class="ad-panel-content active">
        <h2>Change password</h2>
        <input type="password" placeholder="Old password" required="required" aria-label="">
        <input type="password" placeholder="New password" required="required" aria-label="">
        <input type="password" placeholder="Repeat new password" required="required" aria-label="">
        <button>Change</button>
    </div>

    <div id="panel2" class="ad-panel-content">
        <h2>Users</h2>
        <p>All users in DB will be showed here</p>

        <table border="1">
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Role</th>
            </tr>
            <?php
            foreach ($users as $user) {
                ?>
                <tr>
                    <td><?= $user->id ?></td>
                    <td><?= $user->username ?></td>
                    <td><?= $user->role ?></td>
                </tr>
                <?php
            }
            ?>
        </table>

    </div>

</div>
