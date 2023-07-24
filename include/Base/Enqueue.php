<?php

namespace Inc\Base;

use Inc\Controllers\BaseController;

class Enqueue extends BaseController {
	public function register() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue' ] );
	}

	/**
	 * Enqueue scripts
	 */
	public function enqueue() {
		// google code prettify
		wp_enqueue_style( 'peachCoreCodePrettifyStyle', $this->plugin_url . 'assets/prettify.css', [], null );
		wp_enqueue_script( 'peachCoreCodePrettifyScript', $this->plugin_url . 'assets/prettify.js', [], null );

		// enable wp builtin media upload used in MediaWidget.php
		wp_enqueue_script('media-upload');
		wp_enqueue_media();

		// override
		wp_enqueue_style( 'peachCoreStyle', $this->plugin_url . 'assets/override.css', [], null );
		wp_enqueue_script( 'peachCoreScript', $this->plugin_url . 'assets/override.js', [], null );
	}
}