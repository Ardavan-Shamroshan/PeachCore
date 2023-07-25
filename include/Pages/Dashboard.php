<?php

namespace Inc\Pages;

use Inc\Api\Callbacks\ManagerCallbacks;
use Inc\Api\Settings;
use Inc\Controllers\BaseController;

class Dashboard extends BaseController {
	public Settings $settings;
	public ManagerCallbacks $callbacks_manager;
	public array $pages;

	public function register() {
		$this->settings          = new Settings();
		$this->callbacks_manager = new ManagerCallbacks();

		// menu, submenu pages
		$this->set_pages();

		// custom fields
		$this->set_settings();
		$this->set_sections();
		$this->set_fields();

		$this->settings
			->add_pages( $this->pages )
			->with_subpage( 'پیشخوان هلو' )
			->register();
	}

	/**
	 * set admin menu, submenu pages
	 */

	// initialize (array) pages
	public function set_pages() {
		$this->pages = [
			[
				'page_title' => 'هسته هلو',
				'menu_title' => 'هسته هلو',
				'capability' => 'manage_options',
				'menu_slug'  => 'peach-core',
				'callback'   => [ $this, 'admin_dashboard' ],
				'icon_url'   => 'dashicons-store',
				'position'   => 25
			]
		];
	}

	public function admin_dashboard() {
		return require_once $this->plugin_path . 'templates/admin.php';
	}

	/**
	 * Register custom fields
	 */

	// set custom fields settings
	public function set_settings() {
		$args[] = [
			'option_group' => 'peach_core_plugin_settings',
			'option_name'  => 'peach_core_plugin',
			'callback'     => [ $this->callbacks_manager, 'checkbox_sanitize' ],
		];

		$this->settings->set_settings( $args );
	}

	// set custom fields sections
	public function set_sections() {
		$args = [
			[
				'id'       => 'peach_admin_index',
				'title'    => 'تنظیمات افزونه',
				'callback' => [ $this->callbacks_manager, 'admin_section_manager' ],
				'page'     => 'peach_core_plugin'
			]
		];

		$this->settings->set_sections( $args );
	}

	// set custom fields input fields
	public function set_fields() {
		$args = [];
		foreach ( $this->setting_managers as $key => $value ) {
			$args[] = [
				'id'       => $key,
				'title'    => $value,
				'callback' => [ $this->callbacks_manager, 'checkbox_field' ],
				'page'     => 'peach_core_plugin',
				'section'  => 'peach_admin_index',
				'args'     => [ 'option_name' => 'peach_core_plugin', 'label_for' => $key, 'class' => 'ui-toggle' ]
			];
		}

		$this->settings->set_fields( $args );
	}
}