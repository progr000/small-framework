<?php
/** @var Core\ViewDriver $view */

$vars['title'] = 'Main page';

$view->putInCssStack('/css/simple-html/index.css');
$view->putInJsStack('/js/simple-html/index.js');

echo "PHP-Version: " . phpversion();
cookie()->make('test_cookie_var', 125.22, 120);

dump(cookie('test_cookie_var', 'empty'));
?>
Just main page

