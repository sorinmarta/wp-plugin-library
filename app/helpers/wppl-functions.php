<?php

/**
 * Returns a dump of the given property and kills the process
 *
 * @param $body
 *
 * @return bool
 */
if( ! function_exists( 'wppl_dd' ) ){
	function wppl_dd( $body ): bool
	{
		return WPPL_Helper::dd( $body );
	}	
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
if( ! function_exists( 'wppl_redirect' ) ){
	function wppl_redirect( $url, $type = null, $message = null ): bool
	{
		return WPPL_Helper::redirect( $url, $type, $message );
	}
}

/**
 * If an option exists in the WordPress API it updates it. Or creates a new one if it doesn't exist
 *
 * @param $tag
 * @param $value
 *
 * @return bool
 */
if(!function_exists('wppl_add_or_update_option')) {
	function wppl_add_or_update_option( $tag, $value ): bool {
		return Helpers\WPPL_Helper::add_or_update_option( $tag, $value );
	}
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
if( ! function_exists( 'wppl_add_or_update_user_meta' ) ) {
	function wppl_add_or_update_user_meta( $user_id, $tag, $value ): bool {
		return WPPL_Helper::add_or_update_user_meta( $user_id, $tag, $value );
	}
}