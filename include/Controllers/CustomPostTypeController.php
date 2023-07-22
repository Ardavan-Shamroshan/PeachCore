<?php

namespace Inc\Controllers;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Settings;

class CustomPostTypeController extends BaseController {
	public Settings $settings;
	public AdminCallbacks $callbacks;

	public array $subpages = [];

	public array $custom_post_types = [];

	public function register() {
		if ( ! $this->activated( 'cpt_manager' ) ) {
			return;
		}

		$this->settings  = new Settings();
		$this->callbacks = new AdminCallbacks();

		// menu, submenu pages
		$this->set_subpages();
		$this->settings
			->add_subpages( $this->subpages )
			->register();

		$this->storeCustomPostTypes();

		if ( ! empty( $this->custom_post_types ) ) {
			add_action( 'init', [ $this, 'register_custom_post_type' ] );
		}
	}

	/**
	 * Define submenu page
	 */
	public function set_subpages() {
		$this->subpages = [
			[
				'parent_slug' => 'peach-core',
				'page_title'  => 'پست اختصاصی',
				'menu_title'  => 'پست اختصاصی',
				'capability'  => 'manage_options',
				'menu_slug'   => 'peach-core-custom-post-type-submenu',
				'callback'    => [ $this->callbacks, 'custom_post_type' ]
			]
		];
	}

	public function storeCustomPostTypes() {
		$this->custom_post_types = [
			[
				'post_type'     => 'peach_products',
				'name'          => 'محصولات',
				'singular_name' => 'محصول',
				'public'        => true,
				'has_archive'   => true,
			],
		];
	}

	// initialize (array) subpages
	public function register_custom_post_type() {
		foreach ( $this->custom_post_types as $post_type ) {
			register_post_type( $post_type['post_type'], [
				'labels'      => [
					'name'          => $post_type['name'],
					'singular_name' => $post_type['singular_name'],
				],
				'public'      => $post_type['public'],
				'has_archive' => $post_type['has_archive'],
			] );
		}

	}
}