<?php

namespace Controllers;

use Core\ControllerDriver;
use Core\RequestDriver;
use Models\WHMCS\Client;

class TestController extends ControllerDriver
{
    /**
     * @param RequestDriver $r
     * @return string|void
     */
    public function dispatch(RequestDriver $r)
    {
        $act = trim($r->route(), "/");
        $act = explode("/", $act);
        if (isset($act[1])) {
            $method = $act[1];
        }
        if (!isset($method)) {
            $method = $r->get('action', 'test');
        }
        if (method_exists($this, $method)) {
            return $this->$method($r);
        } else {
            return "please set ?action=action_name or /test/action_name";
        }
    }

    private function act1(RequestDriver $r)
    {
        return '--act1--';
    }

    private function act2(RequestDriver $r)
    {
        return '--act2--' . implode(">", $r->get());
    }

    /**
     * @param RequestDriver $r
     * @return void
     * @throws \Core\Exceptions\DbException
     */
    private function testEagerRelations(RequestDriver $r)
    {
        //dd(\PDO::getAvailableDrivers());
        //dd(App::$DbInstances['sqlite-for-developing']->exec('create table foo (col_1 number, col_2 varchar2)'));
//        $invoices = Invoice::query()
//            ->with(['client' => ['currency' => function ($builder) {
//                $builder
//                    //->where("code != :code", ['code' => 'EUR'])
//                    ->orderBy(['id' => 'ASC']);
//            }]])
////            ->with(['client' => function ($builder) {
////                $builder->orderBy(['id' => 'ASC']);
////            }])
//            ->orderBy(['userid' => 'DESC', 'id' => 'ASC'])
//            ->limit(3)
//            ->all();
//        dump($invoices);
//        dump($invoices[0]->client());
//        dump($invoices[0]->client()->currency());
//        dump($invoices[1]->client());
//        dump($invoices[1]->client()->currency());
//        dump($invoices[2]->client());
//        dump($invoices[2]->client()->currency());

        $client = Client::query()
            ->with(['invoices' => function ($builder) {
                //$builder->where(['status' => 'UnPaid']);
            }])
            ->where('id IN (11, 12)')
            ->all();
        dump($client[0]);
        dump($client[0]->invoices());
        dump($client[1]);
        dump($client[1]->invoices());

//        $invoices2 = Invoice::query()
//            //->where(['userid' => 1])
//            ->with(['client'])
//            ->orderBy(['userid' => 'DESC', 'id' => 'ASC'])
//            ->limit(2)
//            ->all();
//        dump($invoices2);
//        dump($invoices2[0]->client());
//        dump($invoices2[1]->client());
//        //dump($invoices2[2]->client());
//
//        dump('end');
//        dump(RelationshipContainer::$_mainResultContainer, RelationshipContainer::$_relatedResultsContainer, RelationshipContainer::$_withRelations);
        exit;
    }
}