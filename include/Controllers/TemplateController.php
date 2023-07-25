<?php

namespace Inc\Controllers;

class TemplateController extends BaseController {
	public $templates;

	public function register() {
		if ( ! $this->activated( 'custom_template' ) ) {
			return;
		}

		$this->templates = [
			'page-template/two-columns-tpl.php' => 'Two Columns Layout',
		];

		// register custom template in wp templates array
		add_filter( 'theme_page_templates', [ $this, 'custom_template' ] );
		// if a post or page has that template, use that not the default
		add_filter( 'template_include', [ $this, 'load_template' ] );
	}


	public function custom_template( $templates ) {
		// full array of wp templates in $templates

		// add our custom templates to wp templates
		return array_merge( $templates, $this->templates );
	}

	public function load_template( $template ) {
		// $template = get the chosen template of post or page that is going to use

		// the page
		global $post;
		if ( ! $post ) {
			return $template;
		}

		// the name of the template
		$template_name = get_post_meta( $post->ID, '_wp_page_template', true );

		if ( ! isset( $this->templates[ $template_name ] ) ) {
			return $template;
		}

		$file = $this->plugin_path . $template_name;


		if ( file_exists( $file ) ) {
			return $file;
		}


		return $template;
	}
}