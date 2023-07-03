<?php

namespace Requests;

use Core\RequestDriver;
use Core\ResponseDriver;

class ContactsRequest extends RequestDriver
{
    /** @var string */
    public $re_captcha_error;

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
            'name'     => "required|string|min:2|max:55",
            'email'  => "required|email",
            'phone' => "phone",
            //'subject' => "string|min:2",
            'subject' => "required|string|min:10",
            'msg' => "required|string|min:10",
            'g-recaptcha-response' => [
                "required",
                "string",
                function ($key, $params, $all_data) {
                    $recaptcha = new \ReCaptcha\ReCaptcha(config('re-captcha-secret-key'));
                    $resp = $recaptcha->verify($all_data[$key], $this->ip());
                    if (!$resp->isSuccess()) {
                        $this->re_captcha_error = json_encode($resp->getErrorCodes());
                        return false;
                    }
                    return true;
                },
            ],
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'phone_regex' => 'Wrong phone format, allowed simbols: [0-9], + and SPACE, min length 5, max length 15',
            'g-recaptcha-response_required' => "Please confirm that you are not a robot",
            'g-recaptcha-response_closure' => "ReCaptcha validation failed. ",// . $this->re_captcha_error,
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
        parent::onFailedValidation();

        (new ResponseDriver())
            ->setStatus(200)
            ->asJson()
            ->setBody(['errors' => $this->errors])
            ->send();
        return false;
    }
}
