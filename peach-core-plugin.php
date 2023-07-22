<?php

/**
 * @package PeachCore
 *
 * Plugin Name: Peach Core هسته هلو
 * Plugin URI: http://peach.com
 * Description: با هسته هلو، یک محیط توسعه افزونه برای برنامه نویسان وردپرس طراحی شده است که به راحتی میتوانند از امکانات توسعه وردپرس به شکل ساده سازی شده اما کارایی حرفه ای استفاده کنند.
 * Version: 1.0.0
 * Author: Ardavan Shamroshan
 * Author URI: http://ardavanshamroshan.com
 * License: GPLv2 or later
 * Text Domain: peach-core
 */

define( "Peach_Core", "1.0.0" );

// Die if accessed externally
defined( 'ABSPATH' ) || die;

// Dump autoload
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

// Define constants
define( 'PEACH_PATH', plugin_dir_path( __FILE__ ) );
define( 'PEACH_URL', plugin_dir_url( __FILE__ ) );
define( 'PEACH', plugin_basename( __FILE__ ) );

// Plugin on activation
function activate_peach_plugin() {
	\Inc\Base\Activate::activate();
}
register_activation_hook( __FILE__, 'activate_peach_plugin' );

// Plugin on deactivation
function deactivate_peach_plugin() {
	\Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_peach_plugin' );

// Initialization
if ( class_exists( 'Inc\Init' ) ) {
	\Inc\Init::register_services();
}

