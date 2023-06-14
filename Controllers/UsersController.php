<?php

namespace Controllers;

use Core\App;
use Core\ControllerDriver;
use Core\Exceptions\DbException;
use Core\Interfaces\RestInterface;
use Models\User;

/**
 * RestController example
 */
class UsersController extends ControllerDriver implements RestInterface
{
    /**
     *
     */
    public function __construct()
    {
        /* change layouts global for all methods in this controller */
        App::$config->set('template-path', config('admin-template-path'));
        $this->layout = "layouts/main";
    }

    /**
     *
     */
    public function index()
    {
        return $this->render('pages/users/list', [
            'users' => User::find()->orderBy(['id' => 'ASC'])->get(),
        ]);
    }

    /**
     * @param int $id
     * @throws DbException
     */
    public function view($id)
    {
        return $this->render('pages/users/view', [
            'user' => User::findOrFail(intval($id)),
        ]);
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