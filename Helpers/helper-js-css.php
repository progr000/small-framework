<?php

if (!function_exists('minimize')) {
    /**
     * @param string $str
     * @return string
     */
    function minimize($str)
    {
        if (!config('minimize-plain-css-js', false)) {
            return $str;
        }
        return str_replace(
            ["\n", "\r\n", ": ", "; ", "} ", "{ ", " }", " {", " =", "= ", ", ", " ,"],
            ["", "", ":", ";", "}", "{", "}", "{", "=", "=", ",", ","],
            preg_replace("/[\s]+/", " ", $str)
        );
    }
}
