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
    'web-console' => "/web-console/web-console-runner.php",

    'Invoices Rest-Api' => [
        'list' => "/invoice-api-usage",
        'item(2)' => "/invoice-api-usage/2",
        'Pdf for item(2)' => "/invoice-api-usage/2/pdf",
        'Example fail Auth' => "/invoice-api-usage/2?bearer=ddddd",
        'Example wrong Method' => "/invoice-api-usage/2/edit",
        'Example wrong Url' => "/invoice-api-usage/2/not-exist",
    ],
];

/**
 * Draw menu
 * @param array $data
 * @return void
 */
function showMenu(array $data)
{
    $current_page = Core\App::$request->fullUrl();
    foreach ($data as $name => $url) {
        if (is_array($url)) {
            ?>
            <li><?= $name ?>
                <br>
                <ul>
                    <?php showMenu($url) ?>
                </ul>
            </li>
            <?php
        } else {
            if ($current_page === $url) { $vars['title'] = $name; }
            ?>
            <li><a class="<?= ($current_page === $url)  ? 'selected' : '' ?>" href="<?= $url ?>"><?= $name ?></a></li>
            <?php
        }
    }
}
?>

<ul>
    <?php
    showMenu($menu);
    ?>
</ul>
