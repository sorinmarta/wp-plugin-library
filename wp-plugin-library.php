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

 define('WPPL_PATH', WP_PLUGIN_DIR . '/wp-plugin-library');

 class WP_Plugin_Helper{
     public function __construct(){
         require WPPL_PATH . '/app/lib/wppl-loader.php';
         add_action('admin_menu', array($this, 'admin_page'));
     }

     public function admin_page(){
         add_menu_page('WP Plugin library', 'WP Plugin library', 'manage_options','wp-plugin-library', array($this, 'callback'));
     }

     public function callback(){
         $nonce = wp_create_nonce('sorin-test');
         if(WPPL_Form::check_nonce($nonce, 'sorin-test')){
             echo 'works';
         }else{
             echo 'no works';
         }
     }
 }

 new WP_Plugin_Helper();