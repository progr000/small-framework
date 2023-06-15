<?php

namespace Requests\Examples;

class ExampleValidator
{
    public $errorMessage = "Value is wrong for ExampleValidator";

    public function __invoke($value, array $params = [], array $all_data = [])
    {
        //dump($value, $params, $all_data);
        return true;
        //return false;
    }
}