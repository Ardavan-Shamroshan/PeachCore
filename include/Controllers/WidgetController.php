<?php

namespace Inc\Controllers;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Settings;

class WidgetController extends BaseController {
	public Settings $settings;
	public AdminCallbacks $callbacks;

	public array $subpages = [];

	public function register() {
		if ( ! $this->activated( 'media_widget' ) ) {
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
				'page_title'  => 'رسانه ابزارک',
				'menu_title'  => 'رسانه ابزارک',
				'capability'  => 'manage_options',
				'menu_slug'   => 'peach-core-media-widget-submenu',
				'callback'    => [ $this->callbacks, 'media_widget' ]
			]
		];
	}

}