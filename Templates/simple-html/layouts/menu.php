<?php
$controller = Core\App::$route->getController();
$action = Core\App::$route->getAction();
$pattern = Core\App::$route->getRoutePatern();

$menu = [
    'Index' => "/",
    'Some usage example 1(response as View)' => "/some-examples?test_int=5&test_double=4&test_string1=as_view",
    'Some usage example 1(response as String)' => "/some-examples?test_int=5&test_double=4&test_string1=as_string",
    'Some usage example 2<br>(response as Response)' => "/some-examples?test_int=5&test_double=4&test_string1=as_response",
    'Some usage example 3<br>(fail validation)' => "/some-examples?test_int=1&test_double=1",
    'Hello' => "/hello/everybody",
    'phpinfo()' => "/info",
    'phpinfo(), example route' => "/info2/any1/any2?any3=any4&any5=...",
    'echo, example route' => "/echo/any1/any2?any3=any4&any5=...",

    'Invoices Rest-Api' => [
        'list' => "/invoice-api-usage",
        'item(2)' => "/invoice-api-usage/2",
        'Pdf for item(2)' => "/invoice-api-usage/2/pdf",
        'Example fail Auth' => "/invoice-api-usage/2?bearer=ddddd",
        'Example wrong Method' => "/invoice-api-usage/2/edit",
        'Example wrong Url' => "/invoice-api-usage/2/not-exist",
    ],

    'web-console' => "/web-console/web-console-runner.php",

    'level-2' => [
        'menu-2.1' => "#",
        'menu-2.2' => "#",
        'level-3' => [
            'menu-3.1' => "#",
            'menu-3.2' => "#",
            'level-4' => [
                'menu-4.1' => "#",
                'menu-4.2' => "#",
                'menu-4.3' => "#",
            ],
            'menu-3.3' => "#",
        ],
        'menu-2.3' => "#",
    ],
];

/**
 * Draw menu
 * @param array $data
 * @param $level
 * @return void
 */
function showMenu(array $data, $level=1)
{
    $current_page = Core\App::$request->fullUrl();

    echo "<ul class=\"level-{$level}\">";
    foreach ($data as $name => $url) {
        if (is_array($url)) {
            ?>
            <li><?= $name ?>
                <br>
                <?php showMenu($url, $level+1) ?>
            </li>
            <?php
        } else {
            if ($current_page === $url) { $vars['title'] = $name; }
            ?>
            <li><a class="<?= ($current_page === $url)  ? 'selected' : '' ?>" href="<?= $url ?>"><?= $name ?></a></li>
            <?php
        }
    }
    echo "</ul>";
}
?>

<?php
showMenu($menu);
?>
