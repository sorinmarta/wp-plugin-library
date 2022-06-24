<?php

namespace WPPL\Helpers;

class WPPL_Helper{
    static function dd($value): void
    {
        echo '<pre>';
        var_dump($value);
        echo '</pre>';
        die();
    }

    static function redirect($url, $type = null, $message = null): bool
    {
        if ($type != null && $message != null){
            setcookie('wppl_redirect_type', $type, time() + 3600, '/');
            setcookie('wppl_redirect_message', $message, time() + 3600, '/');

            return wp_redirect($url);
        }

        return wp_redirect($url);
    }
}