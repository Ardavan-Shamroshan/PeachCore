<?php

namespace Inc\Pages;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\ManagerCallbacks;
use Inc\Api\Settings;
use Inc\Base\BaseController;

class Dashboard extends BaseController {
	public Settings $settings;
	public AdminCallbacks $callbacks;
	public ManagerCallbacks $callbacks_manager;
	public array $pages;
	public array $subpages;

	public function register() {
		$this->settings          = new Settings();
		$this->callbacks         = new AdminCallbacks();
		$this->callbacks_manager = new ManagerCallbacks();

		// menu, submenu pages
		$this->set_pages();
		$this->set_subpages();

		// custom fields
		$this->set_settings();
		$this->set_sections();
		$this->set_fields();

		$this->settings
			->add_pages( $this->pages )
			->with_subpage( 'پیشخوان هلو' )
			->add_subpages( $this->subpages )
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
				'callback'   => [ $this->callbacks, 'admin_dashboard' ],
				'icon_url'   => 'dashicons-store',
				'position'   => 25
			]
		];
	}

	// initialize (array) subpages
	public function set_subpages() {
		$this->subpages = [
			[
				'parent_slug' => 'peach-core',
				'page_title'  => 'پست اختصاصی',
				'menu_title'  => 'پست اختصاصی',
				'capability'  => 'manage_options',
				'menu_slug'   => 'peach-core-custom-post-type-submenu',
				'callback'    => [ $this->callbacks, 'custom_post_type' ]
			],
			[
				'parent_slug' => 'peach-core',
				'page_title'  => 'طبقه بندی اختصاصی',
				'menu_title'  => 'طبقه بندی اختصاصی',
				'capability'  => 'manage_options',
				'menu_slug'   => 'peach-core-custom-taxonomy-submenu',
				'callback'    => [ $this->callbacks, 'custom_taxonomy_type' ]
			],
			[
				'parent_slug' => 'peach-core',
				'page_title'  => 'ابزارک اختصاصی',
				'menu_title'  => 'ابزارک اختصاصی',
				'capability'  => 'manage_options',
				'menu_slug'   => 'peach-core-custom-widget-submenu',
				'callback'    => [ $this->callbacks, 'custom_widget_type' ]
			],
		];
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