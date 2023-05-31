<?php

namespace Controllers;

use Core\App;
use Core\ControllerDriver;
use Core\DbDriver;
use Core\Exceptions\DbException;
use Core\RequestDriver;
use Core\ResponseDriver;
use Core\WgetDriver;
use Models\Angebot;
use Models\Invoice;
use Models\Test;
use Requests\IndexRequest;


class MainController extends ControllerDriver
{
    /**
     * @return string
     * @throws DbException
     */
    public function index()
    {
        //dd(22222);
        //dd(Angebot::findOne(['an_preis' => "2.9"]));
        //dd(Angebot::find(['an_abr' => "p"], 10, ['an_preis' => "DESC", 'an_id' => "asc"], 165));
        //dd(Angebot::findAll());

        //dd(Angebot::execRawSql("INSERT INTO offenwv (ku_suchen, ku_id) VALUES ('test', 0)"));
        //dd(Angebot::execRawSql("UPDATE Angebot SET an_preis = 2.7 WHERE an_id=7"));
        //dd(Angebot::execRawSql("SELECT TOP 3 * FROM Angebot WHERE an_preis = 2.9"));
        //dd(App::$db->table('countries')->limit(10)->get());
        //dd(Angebot::find()->delete([a]));
        //dd(Test::find()->limit(2)->orderBy(['id'])->delete());
        dd(
            Angebot::find()
                ->select(['test' => "1 test", 't1.an_id', 'an_bez', '"t1"."an_preis"', '`t1`.`an_preis`'])
                //->where("(c=3) OR ((a=1) AND (b=2))")
                ->where(['an_preis' => 2.9, 'an_id' => 555555])
                ->alias("t1")
                ->innerJoin('AngebotProDomainname as t2', 't1.an_id = t2.apd_an_id')
                //->orWhere(['t1.an_id' => 7])
                //->orWhere(['t1.an_id' => 8])
                //->where('test2 = 1')
                //->orWhere(['f1' => 1, 'f2' => 2])
                //->orWhere(['f3' => 3])
                ->limit(5)
                ->orderBy(['t1.an_id' => 'DESC', '"t1"."an_code"' => 'DESC', 'an_rabatt'])
                //->delete()
                ->get()
                //->prepareRawSql()
        );

        $a = Angebot::findOne(['an_id' => 7]);
        $a->an_preis = "2.9";
        dd($a->save(), App::$DbInstances['weblandAdmin']->getErrors());

        $res = Invoice::findAll();
        dump($res);

        $db2 = DbDriver::getInstance('mysql-for-developing');
        dump($db2->exec("SELECT * FROM database_migrations")->fetchAll());
        dump(App::$DbInstances['mysql-for-developing']->exec("select 3")->fetchAll());

        dump(App::$db->exec("SELECT * FROM tbl_anrede")->fetchAll());
        dump(App::$db->getErrors());

        return $this->render('main/index');
    }

    /**
     * @param IndexRequest $r
     * @param mixed $p1
     * @return string|ResponseDriver
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