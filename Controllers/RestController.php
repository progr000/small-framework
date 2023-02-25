<?php

namespace Controllers;

use vendor\Core\App;
use vendor\Core\Interfaces\RestInterface;

/**
 * RestController example
 */
class RestController extends Controller implements RestInterface
{
    /**
     *
     */
    public function index()
    {
        var_dump(1111);exit;
        //dd('rest/index', App::$request);
    }

    /**
     * @param int $id
     */
    public function view($id)
    {
        dd('rest/view', $id, App::$request);
    }

    /**
     * @param int $id
     */
    public function edit($id)
    {
        dd('rest/edit', $id, App::$request);
    }

    /**
     * @param int $id
     */
    public function update($id)
    {
        dd('rest/update', $id, App::$request);
    }

    /**
     *
     */
    public function create()
    {
        dd('rest/create', App::$request);
    }

    /**
     *
     */
    public function store()
    {
        dd('rest/store', App::$request);
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        dd('rest/delete', $id, App::$request);
    }
}