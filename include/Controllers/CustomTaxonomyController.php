<?php

namespace Inc\Controllers;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Settings;

class CustomTaxonomyController extends BaseController {
	public Settings $settings;
	public AdminCallbacks $callbacks;

	public array $subpages = [];

	public function register() {
		if ( ! $this->activated( 'taxonomy_manager' ) ) {
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
				'page_title'  => 'طبقه بندی اختصاصی',
				'menu_title'  => 'طبقه بندی اختصاصی',
				'capability'  => 'manage_options',
				'menu_slug'   => 'peach-core-custom-taxonomy-submenu',
				'callback'    => [ $this->callbacks, 'custom_taxonomy_type' ]
			]
		];
	}
}