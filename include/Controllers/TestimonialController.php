<?php

namespace Inc\Controllers;

class TestimonialController extends BaseController {
	public function register() {
		if ( ! $this->activated( 'testimonial_manager' ) ) {
			return;
		}

		add_action( 'init', array( $this, 'testimonial_custom_post_type' ) );
	}

	public function testimonial_custom_post_type() {
		register_post_type( 'testimonial', [
			'labels'              => [
				'name'          => 'مدیریت گواهی ها',
				'singular_name' => 'مدیریت گواهی'
			],
			'public'              => true,
			'has_archive'         => false,
			'menu-icon'           => 'dashicons-testimonial',
			'exclude_form_search' => true,
			'publicly_queryable'  => false,
			'supports'            => [ 'title', 'editor' ]
		] );
	}
}