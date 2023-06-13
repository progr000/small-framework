<?php

namespace Requests;

use Core\App;
use Core\RequestDriver;
use Models\User;
use Requests\Validators\PasswordRulesValidator;

class ChangePasswordRequest extends RequestDriver
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => [
                'required',
                'string',
                function ($key, $params, $all_data) {
                    /** @var User $user */
                    $user = session('Auth');
                    $db_user = User::findOne(['username' => $user->username, 'password' => md5($all_data[$key]), 'role' => User::ROLE_ADMIN]);
                    //dd($db_user, $user->username, $all_data[$key], md5($all_data[$key]));
                    if ($db_user) {
                        return true;
                    }
                    return false;
                }
            ],
            'password' => [
                'required',
                'string',
                PasswordRulesValidator::class,
            ],
            'repeat_password' => [
                'compareEquals:password',
            ],
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'old_password_closure' => "Wrong old password",
            'repeat_password_compareEquals' => "Password and its confirmation do not match",
        ];
    }

    /**
     * @return false
     */
    public function onFailedValidation()
    {
        parent::onFailedValidation();

        App::$response->redirect('/admin-panel/change-password?error')->send();
        return false;
    }
}
