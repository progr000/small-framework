<?php

namespace Requests\Validators;

class PasswordRulesValidator
{
    const MIN = 8;
    const MAX = 50;
    public $errorMessage;

    /**
     *
     */
    public function __construct()
    {
        $this->errorMessage = __("Bad password. Our rules not allow simple passwords");
    }

    /**
     * @param string $value
     * @param array $params
     * @param array $all_data
     * @return bool
     */
    public function __invoke($value, array $params = [], array $all_data = [])
    {
        if (mb_strlen($value) < self::MIN) {
            $this->errorMessage = __("Password must contain {%min} or more symbols", ['min' => self::MIN]);
            return false;
        }

        if (mb_strlen($value) > self::MAX) {
            $this->errorMessage = __("Password must be not longer than {%max} symbols", ['max' => self::MAX]);
            return false;
        }

        if (!preg_match("/[A-Z]+/", $value)) {
            $this->errorMessage = __("Password must contain one or more uppercase letter");
            return false;
        }

        if (!preg_match("/[0-9]+/", $value)) {
            $this->errorMessage = __("Password must contain one or more numeric symbols");
            return false;
        }

        if (!preg_match("/[^a-z0-9]+/i", $value)) {
            $this->errorMessage = __("Password must contain one or more special symbols");
            return false;
        }

        return true;
    }
}