<?php

namespace Controllers;

use Core\App;
use Core\ControllerDriver;
use Core\Exceptions\BadResponseException;
use Core\Exceptions\IntegrityException;
use Maksym\Config\ConfigException;
use Maksym\Db\Exceptions\DbException;
use Models\Contact;
use Requests\ContactsRequest;

class SaveController extends ControllerDriver
{
    /**
     * @param ContactsRequest $request
     * @return void
     * @throws BadResponseException
     * @throws IntegrityException
     * @throws ConfigException
     * @throws DbException
     */
    public function contacts(ContactsRequest $request)
    {
        $validated = $request->validated();
        /* create new model-record and load data into it */
        $contact = new Contact();
        unset($validated['g-recaptcha-response']); // unset value that is not field in DB
        $contact->load($validated);
        /* save model-record into DB and return answer */
        if ($contact->save()) {
            $ret = [
                'status' => true,
                'message' => __("Das Formular wurde erfolgreich bearbeitet und gespeichert."),
            ];
            mail(
                config('sendmail_to_email'),
                __('Sie haben eine neu Mitteilung'),
                "Sie haben eine neu Mitteilung\n" .
                "\n" .
                "From: {$validated['name']}\n" .
                "Email: {$validated['email']}\n" .
                "Phone: {$validated['phone']}\n" .
                "Subject: {$validated['subject']}\n" .
                "--------------------------------\n" .
                "Message:\n {$validated['msg']}\n" .
                "--------------------------------\n" .
                "Mehr auf admin-panel: " . url('/admin-panel/contacts'),
                [
                    'From' => config('sendmail_from_name') . "<" . config('sendmail_from_email') . ">",
                ]
            );
        } else {
            $ret = [
                'status' => false,
                'message' => __("Beim Speichern Ihrer Nachricht ist ein Fehler aufgetreten. Bitte versuchen Sie es später."),
            ];
        }
        App::$response
            ->setStatus(200)
            ->asJson()
            ->setBody($ret)
            ->send();
    }
}