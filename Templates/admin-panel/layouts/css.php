<?php
/** @var array $vars */

/* css stack initialization */
if (!isset($vars['css-stack']) || !is_array($vars['css-stack'])) {
    $vars['css-stack'] = [];
}
$vars['css-stack'] = array_merge([
    "/css/admin-panel/style.css",
], $vars['css-stack']);

echo css_stack($vars['css-stack'], __WWW_DIR__);
