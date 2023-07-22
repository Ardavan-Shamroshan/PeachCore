<?php

namespace Inc\Base;

class Enqueue extends BaseController {
	public function register() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue' ] );
	}

	/**
	 * Enqueue scripts
	 */
	public function enqueue() {
		wp_enqueue_style( 'myPluginStyle', $this->plugin_url . 'assets/override.css', [], null );
		wp_enqueue_script( 'myPluginScript', $this->plugin_url . 'assets/override.js', [], null );
	}
}