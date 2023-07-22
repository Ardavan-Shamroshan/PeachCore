<?php

/**
 * @package ArdavanPlugin
 *
 * Plugin Name: Ardavan Plugin
 * Plugin URI: http://ardavan.com
 * Description: This is my first attempt on writing a custom plugin for this amazing series.
 * Version: 1.0.0
 * Author: Ardavan Shamroshan
 * Author URI: http://ardavanshamroshan.com
 * License: GPLv2 or later
 * Text DomainL ardavan-plugin
 */

define( "Ardavan_Plugin", "1.0.0" );

// Die if accessed externally
defined( 'ABSPATH' ) || die;

// Dump autoload
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

// Define constants
define( 'ARDAVAN_PATH', plugin_dir_path( __FILE__ ) );
define( 'ARDAVAN_URL', plugin_dir_url( __FILE__ ) );
define( 'ARDAVAN', plugin_basename( __FILE__ ) );

// Plugin on activation
function activate_ardavan_plugin() {
	\Inc\Base\Activate::activate();
}
register_activation_hook( __FILE__, 'activate_ardavan_plugin' );

// Plugin on deactivation
function deactivate_ardavan_plugin() {
	\Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_ardavan_plugin' );

// Initialization
if ( class_exists( 'Inc\Init' ) ) {
	\Inc\Init::register_services();
}

