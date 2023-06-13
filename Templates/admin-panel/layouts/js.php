<?php
/** @var array $vars */
/* js-stack initialization */

if (!isset($vars['js-stack']) || !is_array($vars['js-stack'])) {
    $vars['js-stack'] = [];
}
$vars['js-stack'] = array_merge([
    '/js/simple-html/jquery-3.6.3.min.js',
], $vars['js-stack']);
?>

<?= js_stack($vars['js-stack'], __WWW_DIR__) ?>
