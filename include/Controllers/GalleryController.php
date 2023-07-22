<?php

namespace Inc\Controllers;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Settings;

class GalleryController extends BaseController {
	public Settings $settings;
	public AdminCallbacks $callbacks;

	public array $subpages = [];

	public function register() {
		if ( ! $this->activated( 'gallery_manager' ) ) {
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
				'page_title'  => 'مدیریت تصاویر',
				'menu_title'  => 'مدیریت تصاویر',
				'capability'  => 'manage_options',
				'menu_slug'   => 'peach-core-gallery-manager-submenu',
				'callback'    => [ $this->callbacks, 'gallery_manager' ]
			]
		];
	}
}