<?php
$vars['title'] = 'Main page';
$vars['js-stack'][] = "/js/simple-html/index.js";
$vars['css-stack'][] = "/css/simple-html/index.css";
cookie()->make('test_cookie_var', 125.22, 120);

dump(cookie('test_cookie_var', 'empty'));
?>
Just main page

