<?php

/**
 * Plugin Name:       WordPress Plugin Library
 * Plugin URI:        https://wplibrary.thehusky.dev
 * Description:       A library that helps me and other developers to create other plugins easily
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            Sorin Marta @ TheHuskyDev
 * Author URI:        https://thehusky.dev
 */

define('WPPL_URL', plugin_dir_url(__FILE__));

 if(!defined('WPPL_SLUG')){
     define('WPPL_SLUG', 'wp-plugin-library');
 }

 if(!defined('WPPL_PATH')){
     define('WPPL_PATH', WP_PLUGIN_DIR . '/' . WPPL_SLUG);
 }

 if(!defined('WPPL_APP')){
     define('WPPL_APP', WPPL_PATH . '/app');
 }

 if(!defined('WPPL_LIB')){
     define('WPPL_LIB', WPPL_APP . '/lib');
 }

 if(!defined('WPPL_HELPER')){
     define('WPPL_HELPER', WPPL_APP . '/helpers');
 }

 if(!defined('WPPL_CONTROLLER')){
     define('WPPL_CONTROLLER', WPPL_APP . '/controllers');
 }

 if(!defined('WPPL_MODEL')){
     define('WPPL_MODEL', WPPL_APP . '/models');
 }

 if(!defined('WPPL_ASSET')){
     define('WPPL_ASSET', WPPL_URL . '/assets');
 }

 if(!defined('WPPL_CSS')){
     define('WPPL_CSS', WPPL_ASSET . '/css');
 }

 if(!defined('WPPL_JS')){
     define('WPPL_JS', WPPL_ASSET . '/js');
 }

 if(!defined('WPPL_DB_PREFIX')){
     define('WPPL_DB_PREFIX', 'wppl');
 }

 if(!defined('WPPL_TIME_FORMAT')){
     define('WPPL_TIME_FORMAT', 'Y-m-d H:i:s');
 }

 if(!class_exists('WP_Plugin_Helper')) {
	 class WP_Plugin_Helper {
		 public function __construct() {
			 $this->check_php_version();
			 $this->check_wp_version();
			 require WPPL_PATH . '/app/lib/wppl-loader.php';

//			 add_action('activate_'. WPPL_SLUG .'/'. WPPL_SLUG .'.php', array($this, 'activate'));
//			 add_action('deactivate_'. WPPL_SLUG .'/'. WPPL_SLUG .'.php', array($this, 'deactivate'));
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
		  * Executes when the plugin gets activated
		  *
		  * @return void
		  */
		 public function activate(){
			 new WPPL_Activation_Controller();
		 }

		 /**
		  * Executes when the plugin gets deactivated
		  *
		  * @return void
		  */
		 public function deactivate(){
			 new WPPL_Deactivation_Controller();
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