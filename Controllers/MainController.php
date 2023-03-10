<?php

namespace Controllers;

use Core\App;
use Core\ControllerDriver;
use Core\RequestDriver;
use Core\WgetDriver;
use Requests\IndexRequest;


class MainController extends ControllerDriver
{
    /**
     * @return string
     */
    public function index()
    {
        return $this->render('main/index');
    }

    /**
     * @param IndexRequest $r
     * @param mixed $p1
     * @return string|\Core\ResponseDriver
     */
    public function someExamples(IndexRequest $r, $p1 = null)
    {
        //dd($r, $_SERVER);
        //dd($r instanceof RequestDriver);
        //dd(get_class($r));
        if ($r->validated()['test_string1'] === 'as_response') {

            /* return Response */
            return App::$response->setStatus(200)
                ->setHeader([
                    "X-Timestamp: 111111",
                    "Server: Test",
                    "X-Powered-By: Test",
                ])
                ->asJson()
                ->setBody(['return' => "Set response value here"]);

        } elseif ($r->validated()['test_string1'] === 'as_string') {

            /* return string */
            dump($r, $p1, $_GET);
            dump($r->validated());
            dump($r->getErrors());
            return "Main site-page <br/><hr/><div style=\"background-color: #cccccc; width: 100%; max-height: 200px !important; overflow: auto;\">%%%DEBUG-DATA%%%</div>";

        } else {

            /* return View */
            dump($r, $p1, $_GET);
            dump($r->validated());
            dump($r->getErrors());
            return $this->render('main/some-examples');

        }
    }

    /**
     * Another method for another route example
     * You can remove RequestDriver $r from method
     * or add your own RequestClass as on method index
     * @param string $name
     * @return string
     */
    public function hello(RequestDriver $r, $name = "")
    {
        dump($r);
        if (!trim($name)) $name = 'Stranger';
        return $this->render('main/hello', ['name' => $name]);
    }

    /**
     * @param RequestDriver $r
     * @return string
     */
    public function invoiceApiUsage(RequestDriver $r)
    {
        $url = $r->protocol() . '://' . 'orderdesk.hstest-domain.ch' //$r->host()
            . '/api/invoices' .
            str_replace('/invoice-api-usage', '' , $r->route());

        $utc_timestamp = time();
        $method = 'GET';
        $token = md5($method . $utc_timestamp . App::$config->get('api.api-storage-access-token', uniqid('api.api-storage-access-token')));
        $token = htmlentities(strip_tags($r->all('bearer', $token)));
        $response = WgetDriver::init()
            ->asJson()
            ->setBearerAutorisation($token, ["X-UTC-Timestamp: {$utc_timestamp}"])
            ->get($url);

        return $this->render('main/invoice-api-usage', [
            'response' => $response,
        ]);
    }
}