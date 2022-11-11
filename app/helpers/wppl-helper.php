<?php

if(!class_exists('WPPL_Helper')){
	class WPPL_Helper{

	    /**
	     * Returns a dump of the given property and kills the process
	     *
	     * @param $body
	     *
	     * @return bool
	     */
	    static function dd($value): void
	    {
	        echo '<pre>';
	        var_dump($value);
	        echo '</pre>';
	        die();
	    }

	    /**
	     * Redirects people to a given URL with notifications if needed
	     *
	     * @param $url
	     * @param $type
	     * @param $message
	     *
	     * @return bool
	     */
	    static function redirect($url, $type = null, $message = null): bool
	    {
	        if ($type != null && $message != null){
	            setcookie('wppl_redirect_type', $type, time() + 3600, '/');
	            setcookie('wppl_redirect_message', $message, time() + 3600, '/');

	            return wp_redirect($url);
	        }

	        return wp_redirect($url);
	    }

	    /**
	     * If an option exists in the WordPress API it updates it. Or creates a new one if it doesn't exist
	     *
	     * @param $tag
	     * @param $value
	     *
	     * @return bool
	     */
	    static function add_or_update_option($tag, $value): bool
	    {
	        if(get_option($tag)){
	            return update_option($tag, $value);
	        }

	        return add_option($tag, $value);
	    }

	    /**
	     * If an user meta exists in the WordPress database it updates it. Or creates a new one if it doesn't exist
	     *
	     * @param $user_id
	     * @param $tag
	     * @param $value
	     *
	     * @return bool
	     */
	    static function add_or_update_user_meta($user_id, $tag, $value): bool
	    {
	        if(get_user_meta($user_id, $tag)){
	            return update_user_meta($user_id, $tag, $value);
	        }

	        return add_user_meta($user_id, $tag, $value);
	    }
	}
}