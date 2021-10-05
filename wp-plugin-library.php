<?php

/**
 * Plugin Name:       WordPress Plugin Library
 * Plugin URI:        https://github.com/sorinmarta/wp-plugin-library
 * Description:       A library that helps me and other developers to create other plugins easily
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Sorin Marta
 * Author URI:        https://sorinmarta.com
 */

 define('WPPL_SLUG', 'wp-plugin-library');
 define('WPPL_PATH', WP_PLUGIN_DIR . '/' . WPPL_SLUG);

 class WP_Plugin_Helper{
     public function __construct(){
         $this->check_php_version();
         $this->check_wp_version();
         require WPPL_PATH . '/app/lib/wppl-loader.php';
     }

     private function check_php_version(){
        if(phpversion() < 7.4){
            wp_die(__('PHP version cannot be lower than 7.4', WPPL_SLUG));
        }
     }

     private function check_wp_version(){
         global $wp_version;

         if($wp_version < 4.5){
            wp_die(__('WordPress version cannot be lower than 4.5', WPPL_SLUG));
         }
     }
 }

 new WP_Plugin_Helper();