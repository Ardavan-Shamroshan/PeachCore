<?php

namespace Inc\Controllers;

class AuthController extends BaseController {
	public function register() {
		if ( ! $this->activated( 'login_manager' ) ) {
			return;
		}

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );
		add_action( 'wp_head', [ $this, 'add_auth_template' ] );
	}

	public function add_auth_template() {
		// if user logged is
		if ( is_user_logged_in() ) {
			return;
		}

		$file = $this->plugin_path . 'templates/auth.php';

		if ( file_exists( $file ) ) {
			load_template( $file, true );
		}


	}

	public function enqueue() {
		// if user logged is
		if ( is_user_logged_in() ) {
			return;
		}
		wp_enqueue_style( 'authStyle', $this->plugin_url . 'assets/auth.css', [], null );
		wp_enqueue_script( 'authScript', $this->plugin_url . 'assets/auth.js', [], null );
	}
}