<?php
$vars['title'] = 'Main page';
$vars['js-stack'][] = "/simple-html/js/index.js";
$vars['css-stack'][] = "/simple-html/css/main.css?ind";

dump(\Core\App::$locale);
dump(\Core\App::$localization->get('test'));
$_SESSION['app']['locale'] = 'de';
?>
Just main page
