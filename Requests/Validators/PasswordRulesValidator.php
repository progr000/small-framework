<?php

namespace Requests\Validators;

use Core\Exceptions\DbException;
use Models\User;

class PasswordRulesValidator
{
    const MIN = 8;
    const MAX = 50;
    public $errorMessage = "Bad password. Our rules not allow simple passwords";

    /**
     * @param string $value
     * @param array $params
     * @param array $all_data
     * @return bool
     */
    public function __invoke($value, array $params = [], array $all_data = [])
    {
        if (mb_strlen($value) < self::MIN) {
            $this->errorMessage = "Password must contain " . self::MIN . " or more symbols";
            return false;
        }

        if (mb_strlen($value) > self::MAX) {
            $this->errorMessage = "Password must be not longer than " . self::MAX . "symbols";
            return false;
        }

        if (!preg_match("/[A-Z]+/", $value)) {
            $this->errorMessage = "Password must contain one or more uppercase letter";
            return false;
        }

        if (!preg_match("/[0-9]+/", $value)) {
            $this->errorMessage = "Password must contain one or more numeric symbols";
            return false;
        }

        if (!preg_match("/[^a-z0-9]+/i", $value)) {
            $this->errorMessage = "Password must contain one or more special symbols";
            return false;
        }

        return true;
    }
}