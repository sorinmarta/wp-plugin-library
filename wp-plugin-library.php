<?php

namespace WPPL;

use WPPL\Lib\WPPL_View;

/**
 * Plugin Name:       WordPress Plugin Library
 * Plugin URI:        https://huskystudios.digital/wp-plugin-library
 * Description:       A library that helps me and other developers to create other plugins easily
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Sorin Marta @ HuskyStudios
 * Author URI:        https://sorinmarta.com
 */

 const WPPL_SLUG = 'wp-plugin-library' ;
 const WPPL_PATH = WP_PLUGIN_DIR . '/' . WPPL_SLUG;
 const WPPL_APP = WPPL_PATH . '/app';
 const WPPL_LIB = WPPL_APP . '/lib';
 const WPPL_HELPER = WPPL_APP . '/helpers';
 const WPPL_CONTROLLER = WPPL_APP . '/controllers';
 const WPPL_MODEL =  WPPL_APP . '/models';

 class WP_Plugin_Helper{
     public function __construct()
     {
         $this->check_php_version();
         $this->check_wp_version();
         require WPPL_PATH . '/app/lib/wppl-loader.php';
     }

     /**
      * Checks if the PHP version is compatible
      *
      * @return void
      */
     private function check_php_version(): void
     {
        if(phpversion() < 8.0){
            wp_die(__('PHP version cannot be lower than 8.0', WPPL_SLUG));
        }
     }

     /**
      * Checks if the WP version is compatible
      *
      * @return void
      */
     private function check_wp_version(): void
     {
         global $wp_version;

         if($wp_version < 4.5){
            wp_die(__('WordPress version cannot be lower than 4.5', WPPL_SLUG));
         }
     }
 }

 new WP_Plugin_Helper();