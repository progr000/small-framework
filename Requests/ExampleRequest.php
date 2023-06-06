<?php

namespace Requests;

use Core\RequestDriver;
use Core\ResponseDriver;
use Requests\Validators\ExampleValidator;


class ExampleRequest extends RequestDriver
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
            /*
            'var_int'     => "required|int|min:4|max:10",
            'var_double'  => "required|double|min:2.5|max:5.6",
            'var_string1' => "required|string|min:4|max:12",
            'var_string2' => "string|length:10",
            'var_string3' => "string",
            */
            'test' => "int|min:4|max:10|regex:/^[a-z0-9]$/|" . ExampleValidator::class,
            'test2' => [
                'required',
                'int',
                'min:4',
                'max:10',
                'regex:/^[a-z0-9]$/',
                ExampleValidator::class,
            ],
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'test_int' => "",
            'test2_required' => "",
            'test2_min' => "min value for this variable is {%min}",
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
