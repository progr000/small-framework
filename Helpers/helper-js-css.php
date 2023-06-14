<?php

use Core\App;

if (!function_exists('css_stack')) {
    /**
     * @param array $css
     * @param null $www_dir
     * @return string
     */
    function css_stack(array $css, $www_dir = null)
    {
        $str = "";
        foreach ($css as $item) {
            if (strrpos($item, '<style') !== false) {
                $str .= $item . "\n";
            } else {
                $filemtime = file_exists($www_dir . "/" . $item)
                    ? filemtime($www_dir . "/" . $item)
                    : time();
                $str .= '<link href="' . $item . (App::$config->get('IS_DEBUG', false) ? '?v=' . $filemtime : '') . '" rel="stylesheet">' . "\n";
            }
        }
        return $str;
    }
}

if (!function_exists('js_stack')) {
    /**
     * @param array $js
     * @param null $www_dir
     * @return string
     */
    function js_stack(array $js, $www_dir = null)
    {
        $str = "";
        foreach ($js as $item) {
            if (strrpos($item, '<script') !== false) {
                $str .= $item . "\n";
            } else {
                $filemtime = file_exists($www_dir . "/" . $item)
                    ? filemtime($www_dir . "/" . $item)
                    : time();
                $str .= '<script src="' . $item . (App::$config->get('IS_DEBUG', false) ? '?v=' . $filemtime : '') . '"></script>' . "\n";
            }
        }
        return $str;
    }
}
