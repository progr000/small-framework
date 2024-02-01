<?php

if (!function_exists('getImageBase64Src')) {
    /**
     * @param string $image_file
     * @return string
     */
    function getImageBase64Src($image_file)
    {
        if (!file_exists($image_file)) {
            return '';
        }

        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = pathinfo($image_file, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            return '';
        }

        $mimeType = mime_content_type($image_file);

        return "data:image/$mimeType;base64," . base64_encode(file_get_contents($image_file));
    }
}
