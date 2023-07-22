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
		wp_enqueue_style( 'peachCoreStyle', $this->plugin_url . 'assets/override.css', [], null );
		wp_enqueue_script( 'peachCoreScript', $this->plugin_url . 'assets/override.js', [], null );
	}
}