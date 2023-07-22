<?php

namespace Inc\Controllers;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Settings;

class TestimonialController extends BaseController {
	public Settings $settings;
	public AdminCallbacks $callbacks;

	public array $subpages = [];

	public function register() {
		if ( ! $this->activated( 'testimonial_manager' ) ) {
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
				'page_title'  => 'مدیریت گواهی نامه',
				'menu_title'  => 'مدیریت گواهی نامه',
				'capability'  => 'manage_options',
				'menu_slug'   => 'peach-core-testimonial-manager-submenu',
				'callback'    => [ $this->callbacks, 'testimonial_manager' ]
			]
		];
	}

}