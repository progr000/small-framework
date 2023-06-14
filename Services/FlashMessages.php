<?php

namespace Services;

use Core\SessionDriver;

class FlashMessages
{
    const instance = 'flash-messages';

    const FLASH_INFO = 'info';
    const FLASH_SUCCESS = 'success';
    const FLASH_WARNING = 'warning';
    const FLASH_ERROR = 'error';

    /**
     * @param bool $clear_after_access
     * @return array
     */
    public static function getMessages($clear_after_access = true)
    {
        $container = SessionDriver::getInstance(self::instance);
        $messages = $container->all();
        if ($clear_after_access) {
            $container->clear();
        }
        return $messages;
    }

    public static function getDefaultJs()
    {
        return "<script></script>";
    }

    public static function getDefaultCss()
    {
        return "
<style>
.flash-message {
    border-radius: 5px;
    padding: 5px 15px;
    margin: 0 0 10px 0;
}

.flash-error {
    background-color: #d25d5d;
}
.flash-warning {
    background-color: #e0c868;
}
.flash-success {
    background-color: #6fd36b;
}
.flash-info {
    background-color: #609cd7;
}
</style>
        ";
    }

    /**
     * @param bool $clear_after_access
     * @return string
     */
    public static function getMessageAsHtm($clear_after_access = true)
    {
        $ret = "";
        $messages = self::getMessages($clear_after_access);
        foreach ($messages as $message) {
            $ret .= "
            <div id=\"{$message['id']}\"
                 class=\"flash-message flash-{$message['type']}\"
                 data-ttl=\"{$message['ttl']}\">{$message['message']}</div>
            ";
        }
        return $ret;
    }

    /**
     * @param string $message
     * @param string $type
     * @param int $ttl
     * @param string $id
     * @return true
     */
    private static function setMessage($message, $type, $ttl = 0, $id = null)
    {
        $container = SessionDriver::getInstance(self::instance);
        $key = md5($message . $type);
        $container->put([$key => [
            'message' => $message,
            'type' => $type,
            'ttl' => $ttl,
            'id' => isset($id) ? $id : $key
        ]]);
        return true;
    }

    /**
     * @param string $message
     * @param int $ttl
     * @param string $id
     * @return true
     */
    public static function error($message, $ttl = 0, $id = null)
    {
        return self::setMessage($message, self::FLASH_ERROR, $ttl, $id);
    }

    /**
     * @param string $message
     * @param int $ttl
     * @param string $id
     * @return true
     */
    public static function warning($message, $ttl = 0, $id = null)
    {
        return self::setMessage($message, self::FLASH_WARNING, $ttl, $id);
    }

    /**
     * @param string $message
     * @param int $ttl
     * @param string $id
     * @return true
     */
    public static function success($message, $ttl = 0, $id = null)
    {
        return self::setMessage($message, self::FLASH_SUCCESS, $ttl, $id);
    }

    /**
     * @param string $message
     * @param int $ttl
     * @param string $id
     * @return true
     */
    public static function info($message, $ttl = 0, $id = null)
    {
        return self::setMessage($message, self::FLASH_INFO, $ttl, $id);
    }
}