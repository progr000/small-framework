<?php
/** @var $view Core\ViewDriver */
/** @var $data string */

$vars['title'] = __('Web-Console');
isset($vars['phpinfo']) && $view->putInCssStack('/css/admin-panel/phpinfo.css')

?>
<div class="ad-panel-content active">
    <h2><?= $vars['title'] ?></h2>
    <div style="height: 600px;" class="<?= isset($vars['phpinfo']) ? 'ap-phpinfo' : '' ?>">
        <?= $data ?>
    </div>
</div>

