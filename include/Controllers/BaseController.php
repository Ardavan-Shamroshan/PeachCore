<?php

namespace Inc\Controllers;

class BaseController {
	public string $plugin_path;
	public string $plugin_url;
	public string $plugin;
	public array $setting_managers = [];

	public function __construct() {
		$this->plugin_path = plugin_dir_path( dirname( __FILE__, 2 ) );
		$this->plugin_url  = plugin_dir_url( dirname( __FILE__, 2 ) );
		$this->plugin      = plugin_basename( dirname( __FILE__, 3 ) . '/peach-core-plugin.php' );

		// settings manager for dynamically create custom checkbox fields
		$this->setting_managers = [
			'cpt_manager'         => __( 'مدیریت نوع پست های اختصاصی' ),
			'taxonomy_manager'    => __( 'مدیریت دسته بندی' ),
			'media_widget'        => __( 'رسانه ابزارک ها' ),
			'testimonial_manager' => __( 'مدیریت گواهی نامه' ),
			'custom_template'   => __( 'فعال سازی قالب اختصاصی' ),
			'login_manager'       => __( 'ماژول ورود اختصاصی' ),
		];
	}

	public function activated( string $option_name ) {
		$option = get_option( 'peach_core_plugin' );
		// if there was an option with the option_name ($option), then if there was an option with option_name value check the checkbox
		return $option && $option[ $option_name ];
	}
}