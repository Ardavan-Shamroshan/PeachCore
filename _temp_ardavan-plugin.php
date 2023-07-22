<?php

/**
 * @packageArdavanPlugin
 *
 * Plugin Name: Ardavand Plugin
 * Plugin URI: http://ardavan-plugin.com
 * Description: This is my first attempt on writing a custom plugin for this amazing series.
 * Version: 1.0.0
 * Author: Ardavan Shamroshan
 * Author URI: http://ardavanshamroshan.com
 * License: GPLv2 or later
 * Text Domain: ardavand-plugin
 */

define( "Ardavan_Plugin", "1.0.0" );

// Die if accessed externally
defined( 'ABSPATH' ) || die;

// Dump autoload
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

class ArdavandPlugin {

	public $plugin;

	public function __construct() {
		add_action( 'init', [ $this, 'custom_post_type' ] );

		$this->plugin = plugin_basename( __FILE__ );
	}


	/**
	 * Register a custom post type called book in wp_posts table
	 */
	public function custom_post_type() {
		register_post_type( 'book', [ 'public' => true, 'label' => 'اردوان کتاب ها' ] );
	}

	/**
	 * Register admin enqueue scripts
	 */
	public function register() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue' ] );
		add_action( 'admin_menu', [ $this, 'add_admin_pages' ] );

		add_filter( "plugin_action_links_$this->plugin", [ $this, 'settings_link' ] );
	}

	public
	function settings_link( $links ) {
		$settings_link = "<a href='admin.php?page=ardavan-plugin'>Settings</a>";
		$links[]       = $settings_link;

		return $links;
	}

	/**
	 * Enqueue scripts
	 */
	public function enqueue() {
		wp_enqueue_style( 'myPluginStyle', plugins_url( '/assets/override.css', __FILE__ ) );
		wp_enqueue_script( 'myPluginScript', plugins_url( '/assets/override.js', __FILE__ ) );
	}

	/**
	 * Add admin menu pages
	 */
	public function add_admin_pages() {
		add_menu_page(
			'پلاگین اردوان',
			'پلاگین اردوان',
			'manage_options',
			'ardavan-plugin',
			[ $this, 'admin_index' ],
			'dashicons-store',
			25
		);
	}

	public
	function admin_index() {
		require_once plugin_dir_path( __FILE__ ) . 'templates/admin.php';
	}
}

if ( ! class_exists( 'ArdavanPlugin' ) ) {
	die;
}

$instance = new ArdavandPlugin;
$instance->register();


// activation
//require_once plugin_dir_path( __FILE__ ) . 'include/Activate.php';
register_activation_hook( __FILE__, [ 'Inc\Base\Activate', 'activate' ] );

// deactivation
//require_once plugin_dir_path( __FILE__ ) . 'include/Deactivate.php';
register_deactivation_hook( __FILE__, [ 'Inc\Base\Deactivate', 'deactivate' ] );


