<?php

namespace Inc\Controllers;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Settings;

class MembershipController extends BaseController {
	public Settings $settings;
	public AdminCallbacks $callbacks;

	public array $subpages = [];

	public function register() {
		if ( ! $this->activated( 'membership_manager' ) ) {
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
				'page_title'  => 'مدیریت اشتراک',
				'menu_title'  => 'مدیریت اشتراک',
				'capability'  => 'manage_options',
				'menu_slug'   => 'peach-core-membership-manager-submenu',
				'callback'    => [ $this->callbacks, 'membership_manager' ]
			]
		];
	}
}