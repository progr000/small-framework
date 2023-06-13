<?php
/** @var Core\ViewDriver $view */
/** @var string $data */

$vars['title'] = 'Web-Console';
//$vars['js-stack'][] = '/js/admin-panel/init-tabs.js';
?>

<div class="ad-panel-content active">
    <h2>Web-Console</h2>
    <div style="height: 600px;">
        <?= $data ?>
    </div>
</div>

