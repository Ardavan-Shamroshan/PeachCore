<?php

namespace Inc\Controllers;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Settings;

class AuthController extends BaseController {
	public Settings $settings;
	public AdminCallbacks $callbacks;

	public array $subpages = [];

	public function register() {
		if ( ! $this->activated( 'login_manager' ) ) {
			return;
		}

		$this->settings  = new Settings();
		$this->callbacks = new AdminCallbacks();

		// menu, submenu pages
		$this->set_subpages();
		$this->settings
			->add_subpages( $this->subpages )
			->register();
	}

	public function set_subpages() {
		$this->subpages = [
			[
				'parent_slug' => 'peach-core',
				'page_title'  => 'مدیریت ورود',
				'menu_title'  => 'مدیریت ورود',
				'capability'  => 'manage_options',
				'menu_slug'   => 'peach-core-login-manager-submenu',
				'callback'    => [ $this->callbacks, 'login_manager' ]
			]
		];
	}
}