<?php
/** @var $view Core\ViewDriver */
/** @var Exception $e */

$vars['title'] = isset($vars['code']) ? $vars['code'] : '';
?>
<div class="ad-panel-content active">
    <h2 style="color: #9a1a00"><?= $e->getCode() ?> <?= $e->getMessage() ?></h2>
</div>

<pre>
<?= $e->getMessage() ?>
<?php if (config('IS_DEBUG', false)) { ?>
<hr/>
<b>All debug data from framework is:</b>
<?= Core\App::$response->getDebugData() ?>
<hr/>
<b>Backtrace is:</b>
<?= $e->getTraceAsString() ?>
</pre>
<?php } ?>