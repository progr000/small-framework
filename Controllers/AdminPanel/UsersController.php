<?php

namespace Controllers\AdminPanel;

use Core\Exceptions\DbException;
use Core\Exceptions\HttpForbiddenException;
use Core\Interfaces\RestInterface;
use Models\User;

/**
 * RestController example
 */
class UsersController extends _MainController implements RestInterface
{
    /**
     * @throws DbException
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





    /** ********************************************************* **/
    /**
     * @param int $id
     * @throws HttpForbiddenException
     */
    public function edit($id)
    {
        throw new HttpForbiddenException('Not implemented');
    }

    /**
     * @param int $id
     * @throws HttpForbiddenException
     */
    public function update($id)
    {
        throw new HttpForbiddenException('Not implemented');
    }

    /**
     * @throws HttpForbiddenException
     */
    public function create()
    {
        throw new HttpForbiddenException('Not implemented');
    }

    /**
     * @throws HttpForbiddenException
     */
    public function store()
    {
        throw new HttpForbiddenException('Not implemented');
    }

    /**
     * @param int $id
     * @throws HttpForbiddenException
     */
    public function delete($id)
    {
        throw new HttpForbiddenException('Not implemented');
    }

    /**
     * @param int $id
     * @throws HttpForbiddenException
     */
    public function destroy($id)
    {
        throw new HttpForbiddenException('Not implemented');
    }
}