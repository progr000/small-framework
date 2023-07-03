<?php

namespace Controllers\AdminPanel;

use Core\App;
use Core\Exceptions\DbException;
use Core\Exceptions\HttpForbiddenException;
use Core\Interfaces\RestInterface;
use Core\RequestDriver;
use Models\Content;
use Services\FlashMessages;

class ContentsController extends _MainController implements RestInterface
{
    /**
     * @return \Exception|string
     * @throws DbException
     */
    public function index()
    {
        $contents = Content::find()->orderBy(['key' => 'ASC'])->get();
        return $this->render('pages/contents/list', [
            'contents' => $contents,
        ]);
    }

    /**
     * @param RequestDriver $request
     * @return \Core\ResponseDriver
     * @throws DbException
     */
    public function allUpdate(RequestDriver $request)
    {
        $data = $request->post();
        if (isset($data['key'], $data['value']) && is_array($data['key']) && is_array($data['value'])) {
            foreach ($data['key'] as $k => $v) {
                $v = trim($v);
                if (isset($data['value'][$k]) && !empty($v)) {
                    $content = Content::findOne(['key' => $v]);
                    if (!$content) {
                        $content = new Content();
                        $content->key = strip_tags($v);
                    }
                    $content->value = trim($data['value'][$k]);
                    $content->save();
                }
            }
        }
        FlashMessages::success(__('Saved successfully'), 15);
        session()->delete('content-params');

        return $this->redirect(url('/admin-panel/contents'));
    }

    /**
     * @param int $id
     * @return \Core\ResponseDriver
     * @throws DbException
     */
    public function delete($id)
    {
        $content = Content::findOrFail(intval($id));
        $content->delete();
        session()->delete('content-params');
        FlashMessages::success(__('Param was successfully deleted'), 15);

        return $this->redirect(url('/admin-panel/contents'));
    }





    /** ********************************************************* **/
    /**
     * @param int $id
     * @throws HttpForbiddenException
     */
    public function view($id)
    {
        throw new HttpForbiddenException('Not implemented');
    }

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
     *
     * @throws HttpForbiddenException
     */
    public function create()
    {
        throw new HttpForbiddenException('Not implemented');
    }

    /**
     *
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
    public function destroy($id)
    {
        throw new HttpForbiddenException('Not implemented');
    }
}