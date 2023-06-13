<?php
/** @var Core\ViewDriver $view */
/** @var $users \Models\User[] */

$vars['title'] = 'Users';
?>
<div class="ad-panel-content active">
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
