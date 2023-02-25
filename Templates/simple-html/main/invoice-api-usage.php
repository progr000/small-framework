<?php
$vars['title'] = 'Invoices Rest-Api Usage';
?>
<div class="console" style="
    background-color: #333333;
    color: #cccccc;
    border: 1px solid #000;
    padding: 10px;
    height: 400px;
    width: 600px;
    overflow: auto;
    overflow-wrap: break-word;">
<?php
/** @var $response Core\WgetResponse */
echo implode("<br>\n", $response->request_headers());
echo "<hr>";
echo implode("<br>\n", $response->response_headers());
echo "<hr>";
echo $response->body();
?>
</div>