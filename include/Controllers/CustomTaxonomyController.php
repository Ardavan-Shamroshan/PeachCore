<?php

namespace Inc\Controllers;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\CustomTaxonomyCallbacks;
use Inc\Api\Settings;

class CustomTaxonomyController extends BaseController {
	public Settings $settings;
	public AdminCallbacks $callbacks;
	public CustomTaxonomyCallbacks $taxonomy_callbacks;

	public array $subpages = [];
	public array $taxonomies = [];

	public function register() {
		if ( ! $this->activated( 'taxonomy_manager' ) ) {
			return;
		}

		$this->settings           = new Settings();
		$this->callbacks          = new AdminCallbacks();
		$this->taxonomy_callbacks = new CustomTaxonomyCallbacks();

		// menu, submenu pages
		$this->set_subpages();

		$this->set_settings();
		$this->set_sections();
		$this->set_fields();

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

	public function set_settings() {
		$args = [
			[
				'option_group' => 'peach_core_plugin_taxonomy_settings',
				'option_name'  => 'peach_core_plugin_taxonomy',
				'callback'     => [ $this->taxonomy_callbacks, 'taxonomy_sanitize' ]
			]
		];

		$this->settings->set_settings( $args );
	}

	public function set_sections() {
		$args = [
			[
				'id'       => 'peach_taxonomy_index',
				'title'    => 'طبقه بندی اختصاصی',
				'callback' => [ $this->taxonomy_callbacks, 'taxonomy_section_manager' ],
				'page'     => 'peach-core-custom-taxonomy-submenu',
			]
		];


		$this->settings->set_sections( $args );
	}

	// set custom fields sections
	public function set_fields() {

		// post type id, singular name, plural name, public, has_archive
		$args = [
			[
				'id'       => 'taxonomy',
				'title'    => 'شناسه طبقه بندی اختصاصی',
				'callback' => [ $this->taxonomy_callbacks, 'text_field' ],
				'page'     => 'peach-core-custom-taxonomy-submenu', // based on menu/submenu slug
				'section'  => 'peach_taxonomy_index', // based on section id
				'args'     => [
					'option_name' => 'peach_core_plugin_taxonomy', // based on setting option_name
					'label_for'   => 'taxonomy',
					'placeholder' => 'مثال: genre',
					'array'       => 'taxonomy'
				]
			],
			[
				'id'       => 'singular_name',
				'title'    => 'نام مفرد',
				'callback' => [ $this->taxonomy_callbacks, 'text_field' ],
				'page'     => 'peach-core-custom-taxonomy-submenu', // based on menu/submenu slug
				'section'  => 'peach_taxonomy_index', // based on section id
				'args'     => [
					'option_name' => 'peach_core_plugin_taxonomy', // based on setting option_name
					'label_for'   => 'singular_name',
					'placeholder' => 'مثال: ژانر',
					'array'       => 'taxonomy'
				]
			],
			[
				'id'       => 'hierarchical',
				'title'    => 'سلسله مراتب',
				'callback' => [ $this->taxonomy_callbacks, 'checkbox_field' ],
				'page'     => 'peach-core-custom-taxonomy-submenu', // based on menu/submenu slug
				'section'  => 'peach_taxonomy_index', // based on section id
				'args'     => [
					'option_name' => 'peach_core_plugin_taxonomy', // based on setting option_name
					'label_for'   => 'hierarchical',
					'class'       => 'ui-toggle',
					'array'       => 'taxonomy'
				]
			],
		];

		$this->settings->set_fields( $args );
	}
}