<?php

namespace Inc\Controllers;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Settings;

class TemplateController extends BaseController {
	public Settings $settings;
	public AdminCallbacks $callbacks;

	public array $subpages = [];

	public function register() {
		if ( ! $this->activated( 'custom_template' ) ) {
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
				'page_title'  => 'مدیریت قالب',
				'menu_title'  => 'مدیریت قالب',
				'capability'  => 'manage_options',
				'menu_slug'   => 'peach-core-templates-manager-submenu',
				'callback'    => [ $this->callbacks, 'custom_template' ]
			]
		];
	}
}