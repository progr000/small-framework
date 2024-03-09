<?php
/** @var $view Core\ViewDriver */
/** @var $users Models\User[] */

$vars['title'] = __('Users management');

$view->putInCssStack('/css/admin-panel/theme.blue.css');
$view->putInJsStack('/js/admin-panel/jquery.tablesorter.js');
$view->putInJsStack('/js/admin-panel/widget-saveSort.js');
$view->putInJsStack('/js/admin-panel/widget-storage.js');
$view->putInJsStack('/js/admin-panel/table-sort.js');
$view->putInJsStack('/js/admin-panel/common.js');

?>
<div class="ad-panel-content active">
    <h2><?= $vars['title'] ?></h2>

    <table class="list-of-something sort-list-table" data-sortlist="[[1,1]]">
        <thead>
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Role') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($users) {
                foreach ($users as $user) {
                    ?>
                    <tr>
                        <td><?= $user->id ?></td>
                        <td><a href="<?= url("/admin-panel/users/{$user->id}") ?>"><?= $user->username ?></a></td>
                        <td><?= Models\User::getRoles($user->role) ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>

</div>
