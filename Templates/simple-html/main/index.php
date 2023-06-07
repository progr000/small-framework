<?php
$vars['title'] = 'Main page';
$vars['js-stack'][] = "/simple-html/js/index.js";
$vars['css-stack'][] = "/simple-html/css/main.css?ind";
cookie()->make('test_cookie_var', 125.22, 120);

dump(cookie('test_cookie_var', 'empty'));
?>
Just main page

