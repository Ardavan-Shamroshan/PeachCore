<?php

namespace Inc\Api\Callbacks;

class CustomPostTypeCallbacks {
	public function cpt_section_manager() {
		echo 'نوع پست اختصاصی را از طریق این صفحه ایجاد کنید';
	}

	public function cpt_sanitize( $input ) {
		$output = get_option( 'peach_core_plugin_cpt' ) ?: [];

		if ( empty( $output ) ) {
			$output[ $input['post_type'] ] = $input;

			return $output;
		}


		foreach ( $output as $key => $value ) {
			if ( $input['post_type'] === $key ) {
				$output[ $key ] = $input;
			} else {
				$output[ $input['post_type'] ] = $input;
			}
		}

		return $output;
	}

	public function text_field( $args ) {
		$name        = $args['label_for'];
		$placeholder = $args['placeholder'];
		$option_name = $args['option_name'];
		$input       = get_option( $option_name );
		// if there was an option with the option_name ($checkbox), then if there was an option with option_name value check the checkbox

		echo "<input type='text' class='regular-text' id='$name'  name='$option_name" . "[$name]' value='' placeholder='$placeholder' required>";
	}

	public function checkbox_field( $args ) {
		$name  = $args['label_for'];
		$class = $args['class'];

		// initialize input's name like 'option_name[cpt_manager]'
		$option_name = $args['option_name'];
		$checkbox    = get_option( $option_name );
		// if there was an option with the option_name ($checkbox), then if there was an option with option_name value check the checkbox

		echo "<input type='checkbox' id='$name' name='$option_name" . "[$name]' value='1' class='$class'><label for='$name'></label>";
	}
}