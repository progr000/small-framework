<?php
/** @var $view Core\ViewDriver */
/** @var $contents Models\Content[] */

$vars['title'] = __('Content management');

$view->putInCssStack('/css/admin-panel/theme.blue.css');
$view->putInJsStack('/js/admin-panel/jquery.tablesorter.js');
$view->putInJsStack('/js/admin-panel/widget-saveSort.js');
$view->putInJsStack('/js/admin-panel/widget-storage.js');
$view->putInJsStack('/js/admin-panel/table-sort.js');
$view->putInJsStack('/js/admin-panel/common.js');

?>
<div class="ad-panel-content active">
    <h2><?= $vars['title'] ?></h2>

    <form method="post" action="<?= url("/admin-panel/contents/0/all-update") ?>">
        <input type="hidden" name="csrf" value="<?= csrf() ?>">
        <table class="-list-of-something sort-list-table" data-sortlist="[[0,1]]">
            <thead>
                <tr>
                    <th style="width: 10%;"><?= __('KEY') ?></th>
                    <th data-sorter="false"><?= __('VALUE') ?></th>
                    <th class="no-sort" style="width: 5%"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($contents as $content) {
                    ?>
                    <tr>
                        <td data-text="<?= $content->key ?>"><input name="key[]" type="text" readonly="readonly" value="<?= $content->key ?>" aria-label=""></td>
                        <td><textarea name="value[]" style="width: 100%" rows="5" aria-label=""><?= !is_null($content->value) ? htmlentities($content->value) : '' ?></textarea></td>
                        <td style="text-align: center; vertical-align: middle;">
                            <a class="button delete-item"
                               href="<?= url("/admin-panel/contents/{$content->id}/delete") ?>"><?= __('Delete') ?></a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td data-text="" colspan="3">New param: </td>
                </tr>
                <tr>
                    <td data-text=""><input name="key[]" type="text" value="" placeholder="<?= __('Put new unique key here') ?>" aria-label=""></td>
                    <td><textarea name="value[]" style="width: 100%" rows="5" aria-label="" placeholder="<?= __('Put value for this key here') ?>"></textarea></td>
                    <td>
                    </td>
                </tr>
            </tbody>
        </table>
        <input type="submit" value="<?= __('Save') ?>">
        <input type="reset" value="<?= __('Reset') ?>">
    </form>
</div>
