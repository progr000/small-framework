<?php
/** @var $view Core\ViewDriver */
/** @var $new_contacts_count int */

$vars['title'] = __('Dashboard');
$vars['new_contacts_count'] = $new_contacts_count;

?>
<div class="ad-panel-content active">
    <h2><?= $vars['title'] ?></h2>
    <div class="narrow-center">
        <p></p>
        <p><?= __('You have:') ?></p>
        <p><?= __(' - <b>{%count}</b> new Message(s)', ['count' => $new_contacts_count]) ?></p>
    </div>
</div>

