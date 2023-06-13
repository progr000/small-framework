<?php
/** @var Core\ViewDriver $view */
/** @var $users \Models\User[] */

$vars['title'] = 'Change password';
//$vars['js-stack'][] = '/js/admin-panel/init-tabs.js';
?>

<div class="ad-panel-content active">
    <h2>Change password</h2>
    <input type="password" placeholder="Old password" required="required" aria-label="">
    <input type="password" placeholder="New password" required="required" aria-label="">
    <input type="password" placeholder="Repeat new password" required="required" aria-label="">
    <button>Change</button>
</div>

