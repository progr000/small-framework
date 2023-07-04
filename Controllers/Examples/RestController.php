<?php

namespace Controllers\Examples;

use Core\App;
use Core\ControllerDriver;
use Core\Interfaces\RestInterface;

/**
 * RestController example
 */
class RestController extends ControllerDriver implements RestInterface
{
    /**
     *
     */
    public function index()
    {
        dd('rest/index', App::$request);
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

    /**
     * @param $id
     */
    public function destroy($id)
    {
        dd('rest/destroy', $id, App::$request);
    }
}
