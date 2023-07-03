<?php

namespace Requests\Validators;

use Core\Exceptions\DbException;
use Models\User;

class LoginValidator
{
    public $errorMessage;

    /**
     * LoginValidator constructor.
     */
    public function __construct()
    {
        $this->errorMessage = __("Wrong login or password");
    }

    /**
     * @throws DbException
     */
    public function __invoke($value, array $params = [], array $all_data = [])
    {
        if (!empty($all_data['username']) && !empty($all_data['password'])) {
            return User::login($all_data['username'], $all_data['password']);
        } else {
            $this->errorMessage = __('Username and password are required');
        }

        return false;
    }
}