<?php

namespace Requests\Validators;

use DateTime;

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
                    $rule = "/^[0-9]{1,10}(?:\.[0-9]{1,5})?$/";
                    break;
                case 'date':
                    $this->errorMessage = "Value is wrong, should be an array of dates";
                    foreach ($value as $v) {
                        if (!($this->validateDate($v) || $this->validateDate($v, 'Y-m-d'))) {
                            return false;
                        }
                    }
                    break;
                case 'file':
                    return $this->validateFile($value, $params);
                    break;
                default:
                    return true;
            }
        }


        if (isset($rule)) {
            foreach ($value as $v) {
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
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    /**
     * @param $value
     * @param $params
     * @return bool
     */
    private function validateFile($value, $params)
    {
        // check is uploaded file data correct
        if (!isset($value['name'], $value['tmp_name'], $value['size'], $value['type'])) {
            $this->errorMessage = 'File data is brocken';
            return false;
        }

        // check is files presented by upload field
        foreach ($value['tmp_name'] as $tmp_name) {
            if (empty(trim($tmp_name))) {
                $this->errorMessage = 'Value is required';
                return false;
            }
        }

        // check each file for correct type
        if (isset($params['type'])) {
            $expected_types = explode(',', $params['type']);
            foreach ($value['type'] as $type) {
                // check is type of file presented
                if (empty($type)) {
                    $this->errorMessage = "Type of file is undefined";
                    return false;
                }
                // check is file type corresponding with expected
                $found_expected_type = false;
                foreach ($expected_types as $v) {
                    $v = trim($v);
                    if (strrpos($type, $v)) {
                        $found_expected_type = true;
                        break;
                    }
                }
                if (!$found_expected_type) {
                    $this->errorMessage = "Wrong file type. Expected {%type}";
                    return false;
                }
            }
        }

        // check is maximal size of files less than allowed
        if (isset($params['max'])) {
            $max_size = $params['max'];
            $uploaded_size = 0;
            foreach ($value['size'] as $size) {
                $uploaded_size += intval($size);
                if ($uploaded_size > $max_size) {
                    $this->errorMessage = "File to lage, max size {%max} bytes";
                    return false;
                }
            }
        }

        return true;
    }
}
