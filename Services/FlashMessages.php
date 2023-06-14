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

    const html_flash_container_id = 'flash-container';
    const html_flash_message_template = '<div id="{%id}" class="flash-message flash-{%type}" data-ttl="{%ttl}" data-die-time="{%die_time}">{%message}</div>';

    const js_check_die_every = 5; // seconds

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

    /**
     * @return string
     */
    public static function getDefaultJs()
    {
        return "
<script>
(function($) {
    'use strict';
    function checkDie() 
    {
        let now_timestamp = Math.floor(Date.now() / 1000);
        $('#" . self::html_flash_container_id . "').find('.flash-message').each(function() {
            let flash = $(this);
            let die_time = flash.data('die-time');
            if (die_time !== undefined) {
                die_time = parseInt(die_time);
                if (now_timestamp >= die_time) {
                    flash.fadeOut(600, function () {
                        flash.remove();
                    });
                }
            }
        });
        setTimeout(checkDie, " . (self::js_check_die_every*1000) . ");
    }
    window.addFlashMessage = function(message, type, ttl, id = null) {
        let die_time = Math.floor(Date.now() / 1000);
        if (id === null) {
            id = (Math.random() + Math.floor(Date.now() / 1000)).toString(36);
        }
        let test = $('#' + id);
        if (test.length) {
            test.remove();
        }
        if (ttl > 0) { 
            die_time += ttl;
        } else {
            die_time += 31536000;
        }
        let flash = `" . replace_vars(self::html_flash_message_template, [
                'message' => '${message}',
                'type' => '${type}',
                'ttl' => '${ttl}',
                'id' => '${id}',
                'die_time' => '${die_time}'
        ]) . "`;
        $('#" . self::html_flash_container_id . "').prepend($(flash));
    };
    $(document).ready(function() {
        checkDie();
        /*
        $(document).on('click', 'h2', function() {
            addFlashMessage(Date.now(), 'error', 10, 'tttttt');
            addFlashMessage(Date.now(), 'warning', 10);
        });
        */
    });
})(jQuery);
</script>
";
    }

    /**
     * @return string
     */
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
        $ret = '<div id="' . self::html_flash_container_id . '" class="flash-container">';
        $messages = self::getMessages($clear_after_access);
        foreach ($messages as $message) {
            if ($message['ttl'] > 0) {
                $message['die_time'] = time() + $message['ttl'];
            } else {
                $message['die_time'] = time() + 31536000;
            }
            $ret .= replace_vars(self::html_flash_message_template, $message);
        }
        $ret .= '</div>';
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