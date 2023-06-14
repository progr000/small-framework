<?php

use Core\SessionDriver;

if (!function_exists('csrf')) {
    /**
     * @return string
     */
    function csrf()
    {
        $container = SessionDriver::getInstance('csrf');
        return $container->get('csrf', '');
    }
}

if (!function_exists('old')) {
    /**
     * @param string $key
     * @param mixed $default
     * @param bool $clear_after_access
     * @return mixed
     */
    function old($key, $default = '', $clear_after_access = true)
    {
        $container = SessionDriver::getInstance('old-request');
        $old_val = $container->get($key, $default);
        if ($clear_after_access) {
            $container->delete($key);
        }
        return $old_val;
    }
}

if (!function_exists('request_errors')) {
    /**
     * @param string|null $key
     * @param bool $clear_after_access
     * @return mixed
     */
    function request_errors($key = null, $clear_after_access = true)
    {
        $container = SessionDriver::getInstance('error-request');
        if ($key) {
            $error = $container->get($key, null);
            if ($clear_after_access) {
                $container->delete($key);
            }
        } else {
            $error = $container->all();
            if ($clear_after_access) {
                $container->clear();
            }
        }
        return $error;
    }
}
