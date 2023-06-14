<?php

use Core\SessionDriver;

const FLASH_INFO = 'info';
const FLASH_SUCCESS = 'success';
const FLASH_WARNING = 'warning';
const FLASH_ERROR = 'error';

if (!function_exists('set_flash_messages')) {
    /**
     * @param string $message
     * @param string $type
     * @return true
     */
    function set_flash_messages($message, $type = FLASH_ERROR, $ttl = 0, $id = null)
    {
        $container = SessionDriver::getInstance('flash-messages');
        $key = md5($message . $type);
        $container->put([$key => [
            'message' => $message,
            'type' => $type,
            'ttl' => $ttl,
            'id' => isset($id) ? $id : $key
        ]]);
        return true;
    }
}

if (!function_exists('get_flash_messages')) {
    /**
     * @param bool $clear_after_access
     * @return mixed
     */
    function get_flash_messages($clear_after_access = true)
    {
        $container = SessionDriver::getInstance('flash-messages');
        $messages = $container->all();
        if ($clear_after_access) {
            $container->clear();
        }
        return $messages;
    }
}

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
