<?php

namespace Requests;

use Core\App;
use Core\Exceptions\BadResponseException;
use Core\Exceptions\IntegrityException;
use Core\RequestDriver;
use Maksym\Config\ConfigException;
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
     * @throws BadResponseException
     * @throws IntegrityException
     * @throws ConfigException
     */
    public function onFailedValidation()
    {
        parent::onFailedValidation();

        App::$response->redirect(url('/admin-panel/login'))->send();
        return false;
    }
}
