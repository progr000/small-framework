<?php
/** @var $view Core\ViewDriver */
/** @var $contacts Models\Contact[] */

$vars['title'] = __('Messages');

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
                <th><?= __('Date') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Email') ?></th>
                <th><?= __('Phone') ?></th>
                <th><?= __('Subject') ?></th>
                <th data-sorter="false"><?= __('Message') ?></th>
                <th class="no-sort"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($contacts as $contact) {
                ?>
                <tr class="<?= $contact->is_new ? 'tr-bold' : '' ?>">
                    <td><?= $contact->id ?></td>
                    <td><?= $contact->created_at ?></td>
                    <td><a href="<?= url("/admin-panel/contacts/{$contact->id}") ?>"><?= $contact->name ?></a></td>
                    <td><?= $contact->email ?></td>
                    <td><?= $contact->phone ?></td>
                    <td><?= $contact->subject ?></td>
                    <td><?= mb_substr($contact->msg, 0, 100) . "..." ?></td>
                    <td style="text-align: center; vertical-align: middle;">
                        <form class="delete-item"
                              method="post"
                              action="<?= url("/admin-panel/contacts/{$contact->id}") ?>">
                            <input type="hidden" name="_method" value="delete">
                            <input type="hidden" name="csrf" value="<?= csrf() ?>">
                            <input type="submit" value="<?= __('Delete') ?>">
                        </form>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>
