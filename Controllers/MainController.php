<?php

namespace Controllers;

use Core\ControllerDriver;
use Core\DbDriver;
use Core\Exceptions\DbException;
use Core\Providers\RelationshipContainer;
use Models\Contact;
use Models\Content;
use Models\WHMCS\Invoice;

class MainController extends ControllerDriver
{
    /**
     * @throws DbException
     */
    public function __construct()
    {
        parent::__construct();
        Content::putIntoSessionAllContent();
    }

    /**
     * @return \Exception|string
     * @throws DbException
     */
    public function index()
    {
//        $invoices = Invoice::query()
//        //->where(['userid' => 1])
//            ->with(['client'])
//            ->orderBy(['id' => 'ASC', 'userid' => 'ASC'])
//            ->limit(3)
//            ->all();
//        dump($invoices);
//        dump($invoices[0]->client());
//        dump($invoices[1]->client());
//        dump($invoices[2]->client());
//
//        $invoices2 = Invoice::query()
//            //->where(['userid' => 1])
//            ->with(['client'])
//            ->orderBy(['userid' => 'DESC', 'id' => 'ASC'])
//            ->limit(2)
//            ->all();
//        dump($invoices2);
//        dump($invoices2[0]->client());
//        dump($invoices2[1]->client());
        //dump($invoices2[2]->client());

//        dump('end');
//        dd(RelationshipContainer::$_mainResultContainer, RelationshipContainer::$_relatedResultsContainer, RelationshipContainer::$_withRelations);

        //dd(DbDriver::getInstance('postgres-for-developing')->exec("SELECT version()")->fetchAll());
        //dd(Contact::findOrFail(1)->order());
        //Contact::find()->where('1')->all();
        return $this->render('pages/index');
    }

    /**
     * @return \Exception|string
     */
    public function contacts()
    {
        return $this->render('pages/contacts');
    }
}