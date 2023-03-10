<?php

namespace Requests;

use Core\RequestDriver;
use Core\ResponseDriver;


class IndexRequest extends RequestDriver
{
    /**
     * This function - example of possible
     * validation rules at this moment
     * Probably will be created new.
     * New validator methods must be
     * described in ValidatorDriver
     * @return array
     */
    public function rules()
    {
        // here can create some rules
        return [
            'test_int'     => "required|int|min:4|max:10",
            'test_double'  => "required|double|min:2.5|max:5.6",
            'test_string1' => "required|string|min:4|max:12",
            'test_string2' => "string|length:10",
            'test_string3' => "string",
        ];
    }

    /**
     * This method can be disabled in your Request,
     * but then you need to create some logic
     * for fail-validation in controller-method
     * @return false
     */
    public function onFailedValidation()
    {
        (new ResponseDriver())
            ->setStatus(200)
            ->asJson()
            ->setBody(['errors' => $this->errors])
            ->send();
        return false;
    }
}
