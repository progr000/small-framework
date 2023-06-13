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
                    $db_user = User::findOne(['username' => $user->username, 'password' => User::generatePassword($user->username, $all_data[$key]), 'role' => User::ROLE_ADMIN]);
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

        set_flash_messages('Some error on change password', FLASH_ERROR);
        App::$response->redirect('/admin-panel/change-password?error')->send();
        return false;
    }
}
