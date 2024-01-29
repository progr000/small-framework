<?php

namespace Requests\Validators;

class IsArrayValidator
{
    public $errorMessage = "Value is wrong, should be an array of data";

    /**
     * @param mixed $value
     * @param array $params
     * @param array $all_data
     * @return bool
     */
    public function __invoke($value, array $params = [], array $all_data = [])
    {
        if (!is_array($value)) {
            $this->errorMessage = "Value is wrong, should be an array of data";
            return false;
        }

        if (isset($params['datatype'])) {
            switch ($params['datatype']) {
                case 'int':
                    $this->errorMessage = "Value is wrong, should be an array of integer";
                    $rule = "/^[0-9]+$/";
                    break;
                case 'double':
                    $this->errorMessage = "Value is wrong, should be an array of double";
                    $rule = "/^[0-9\.]+$/";
                    break;
                case 'date':
                    $this->errorMessage = "Value is wrong, should be an array of dates";
                    foreach ($value as $k => $v) {
                        if (!($this->validateDate($v) || $this->validateDate($v, 'Y-m-d'))) {
                            return false;
                        }
                    }
                    break;
                default:
                    return true;
            }
        }


        if (isset($rule)) {
            foreach ($value as $k => $v) {
                if (preg_match($rule, $v)) {
                    return true;
                } else {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @param string $date
     * @param string $format
     * @return bool
     */
    private function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = \DateTime::createFromFormat($format, $date);
        //dd($date, $d && $d->format($format) == $date);
        return $d && $d->format($format) == $date;
    }
}