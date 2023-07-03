<?php
/** @var $view Core\ViewDriver */
/** @var $list_of_dumps array */

$vars['title'] = __('Database backup');

$view->putInCssStack('/css/admin-panel/theme.blue.css');
$view->putInJsStack('/js/admin-panel/jquery.tablesorter.js');
$view->putInJsStack('/js/admin-panel/widget-saveSort.js');
$view->putInJsStack('/js/admin-panel/widget-storage.js');
$view->putInJsStack('/js/admin-panel/table-sort.js');
$view->putInJsStack('/js/admin-panel/common.js');

?>
<div class="ad-panel-content active">
    <h2><?= $vars['title'] ?></h2>
    <div class="narrow-center">
        <table class="list-of-something sort-list-table" data-sortlist="[[0,1]]">
            <thead>
            <tr>
                <th><?= __('Filename') ?></th>
                <th class="no-sort"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($list_of_dumps as $file) {
                ?>
                <tr>
                    <td>
                        <a href="<?= url("/admin-panel/backup-database?download=" . basename($file)) ?>"><?= basename($file) ?></a>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                        <form class="delete-item" method="post" action="<?= url("/admin-panel/backup-database") ?>">
                            <input type="hidden" name="_method" value="delete">
                            <input type="hidden" name="csrf" value="<?= csrf() ?>">
                            <input type="hidden" name="file_name" value="<?= basename($file) ?>">
                            <input type="submit" value="<?= __('Delete') ?>">
                        </form>
                    </td>
                </tr>

                <?php
            }
            ?>
            </tbody>
        </table>
        <hr/>
        <form method="post" action="<?= url('/admin-panel/backup-database') ?>">
            <input type="hidden" name="csrf" value="<?= csrf() ?>">
            <input type="submit" value="<?= __('Create new backup') ?>">
        </form>
    </div>
</div>
