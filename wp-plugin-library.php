<?php

namespace WPPL;

use WPPL\Lib\WPPL_View;

/**
 * Plugin Name:       WordPress Plugin Library
 * Plugin URI:        https://wplibrary.thehusky.dev
 * Description:       A library that helps me and other developers to create other plugins easily
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      8.0
 * Author:            Sorin Marta @ TheHuskyDev
 * Author URI:        https://thehusky.dev
 */

define('WPPL_URL', plugin_dir_url(__FILE__));

 const WPPL_SLUG = 'wp-plugin-library' ;
 const WPPL_PATH = WP_PLUGIN_DIR . '/' . WPPL_SLUG;
 const WPPL_APP = WPPL_PATH . '/app';
 const WPPL_LIB = WPPL_APP . '/lib';
 const WPPL_HELPER = WPPL_APP . '/helpers';
 const WPPL_CONTROLLER = WPPL_APP . '/controllers';
 const WPPL_MODEL =  WPPL_APP . '/models';
 const WPPL_ASSET = WPPL_URL . '/assets';
 const WPPL_CSS = WPPL_ASSET . '/css';
 const WPPL_JS = WPPL_ASSET . '/js';
 const WPPL_DB_PREFIX = 'wppl';
 const WPPL_TIME_FORMAT = 'Y-m-d H:i:s';

 if(!class_exists('WP_Plugin_Helper')) {
	 class WP_Plugin_Helper {
		 public function __construct() {
			 $this->check_php_version();
			 $this->check_wp_version();
			 require WPPL_PATH . '/app/lib/wppl-loader.php';

			 add_action('activate_'. WPPL_SLUG .'/'. WPPL_SLUG .'.php', 'WPPL_Activation_Controller::init()');
			 add_action('deactivate_'. WPPL_SLUG .'/'. WPPL_SLUG .'.php', 'WPPL_Deactivation_Controller::init()');
		 }

		 /**
		  * Checks if the PHP version is compatible
		  *
		  * @return void
		  */
		 private function check_php_version(): void {
			 if ( phpversion() < 7.4 ) {
				 wp_die( __( 'PHP version cannot be lower than 7.4', WPPL_SLUG ) );
			 }
		 }

		 /**
		  * Checks if the WP version is compatible
		  *
		  * @return void
		  */
		 private function check_wp_version(): void {
			 global $wp_version;

			 if ( $wp_version < 5.2 ) {
				 wp_die( __( 'WordPress version cannot be lower than 5.2', WPPL_SLUG ) );
			 }
		 }
	 }

	 new WP_Plugin_Helper();
 }