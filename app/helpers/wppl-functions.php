<?php

/**
 * Returns a dump of the given property and kills the process
 *
 * @param $body
 *
 * @return bool
 */
function wppl_dd($body): bool
{
    return \WPPL\Helpers\WPPL_Helper::dd($body);
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
function wppl_redirect($url, $type = null, $message = null): bool
{
    return \WPPL\Helpers\WPPL_Helper::redirect($url, $type, $message);
}

/**
 * If an option exists in the WordPress API it updates it. Or creates a new one if it doesn't exist
 *
 * @param $tag
 * @param $value
 *
 * @return bool
 */
function add_or_update_option($tag, $value): bool
{
    return \WPPL\Helpers\WPPL_Helper::add_or_update_option($tag, $value);
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
function add_or_update_user_meta($user_id, $tag, $value): bool
{
    return \WPPL\Helpers\WPPL_Helper::add_or_update_user_meta($user_id, $tag, $value);
}