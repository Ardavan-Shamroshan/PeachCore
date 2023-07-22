<?php

namespace Inc\Base;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Settings;


class CustomPostTypeController extends BaseController {
	public Settings $settings;
	public AdminCallbacks $callbacks;

	public array $subpages = [];

	public function register() {
		$option = get_option( 'peach_core_plugin' );
		// if there was an option with the option_name ($option), then if there was an option with option_name value check the checkbox
		$activated = $option && $option['cpt_manager'];

		if ( ! $activated ) {
			return;
		}

		$this->settings  = new Settings();
		$this->callbacks = new AdminCallbacks();

		// menu, submenu pages
		$this->set_subpages();
		$this->settings
			->add_subpages( $this->subpages )
			->register();

		add_action( 'init', [ $this, 'activate' ] );
	}

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

	// initialize (array) subpages
	public function activate() {
		register_post_type( 'peach_products', [
			'labels'      => [
				'name'          => 'محصولات هلو',
				'singular_name' => 'محصول هلو',
			],
			'public'      => true,
			'has_archive' => true,
		] );
	}

	public function check_activation() {
		$option = get_option( 'peach_core_plugin' );
		// if there was an option with the option_name ($option), then if there was an option with option_name value check the checkbox
		$activated = $option && $option['cpt_manager'];

		if ( ! $activated ) {
			return;
		}
	}
}