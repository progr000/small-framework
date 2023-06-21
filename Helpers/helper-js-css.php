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

if (!function_exists('asset')) {
    /**
     * @param string $file
     * @return string
     */
    function asset($file)
    {
        return \Core\App::$site_url . "/" . ltrim($file, '/');
    }
}
