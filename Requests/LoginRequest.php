<?php

namespace Requests;

use Core\App;
use Core\RequestDriver;
use Requests\Validators\LoginValidator;


class LoginRequest extends RequestDriver
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'username' => "required|string", //"required|string|min:5|max:55",
            'password' => [
                'required',
                'string',
                //'min:8',
                //'max:255',
                LoginValidator::class,
            ],
        ];
    }

    /**
     * @return false
     */
    public function onFailedValidation()
    {
        parent::onFailedValidation();

        App::$response->redirect('/admin-panel/login')->send();
        return false;
    }
}
