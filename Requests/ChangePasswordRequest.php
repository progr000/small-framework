<?php

namespace Requests;

use Core\App;
use Core\RequestDriver;
use Models\User;
use Requests\Validators\PasswordRulesValidator;
use Services\FlashMessages;

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
                    $db_user = User::findOne(['username' => App::$user->username, 'password' => User::generatePassword(App::$user->username, $all_data[$key]), 'role' => User::ROLE_ADMIN]);
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
            'old_password_closure' => __("Wrong old password"),
            'repeat_password_compareEquals' => __("Password and its confirmation do not match"),
        ];
    }

    /**
     * @return false
     */
    public function onFailedValidation()
    {
        parent::onFailedValidation();

        FlashMessages::error(__('Some error on change password'), 15);
        App::$response->redirect(url('/admin-panel/change-password?error'))->send();
        return false;
    }
}
