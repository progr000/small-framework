<?php

namespace Controllers\AdminPanel;

use Core\Exceptions\DbException;
use Core\Exceptions\HttpForbiddenException;
use Core\Interfaces\RestInterface;
use Models\Contact;
use Services\FlashMessages;

/**
 * RestController example
 */
class ContactsController extends _MainController implements RestInterface
{
    /**
     * @throws DbException
     */
    public function index()
    {
        return $this->render('pages/contacts/list', [
            'contacts' => Contact::find()->orderBy(['created_at' => 'DESC', 'id' => 'DESC'])->get(),
        ]);
    }

    /**
     * @param int $id
     * @throws DbException
     */
    public function view($id)
    {
        $contact = Contact::findOrFail(intval($id));
        $contact->is_new = Contact::IS_OLD;
        $contact->save();
        return $this->render('pages/contacts/view', [
            'contact' => $contact,
        ]);
    }

    /**
     * @param int $id
     * @throws DbException
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail(intval($id));
        $contact->delete();
        FlashMessages::success(__('Kontakt wurde erfolgreich gelöscht'), 15);

        return $this->redirect(url('/admin-panel/contacts'));
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
    public function delete($id)
    {
        throw new HttpForbiddenException('Not implemented');
    }
}