<?php

namespace Inc\Api\Callbacks;

class CustomPostTypeCallbacks {
	public function cpt_section_manager() {
		echo 'نوع پست اختصاصی را از طریق این صفحه ایجاد کنید';
	}

	public function cpt_sanitize( $input ) {
		return $input;
	}

	public function text_field( $args ) {
		$name        = $args['label_for'];
		$placeholder = $args['placeholder'];
		$option_name = $args['option_name'];
		$input       = get_option( $option_name );
		// if there was an option with the option_name ($checkbox), then if there was an option with option_name value check the checkbox
		$value = ( $input && $input[ $name ] ) ? $input[ $name ] : '';

		echo "<input type='text' class='regular-text' id='$name'  name='$option_name" . "[$name]' value='$value' placeholder='$placeholder'>";
	}

	public function checkbox_field( $args ) {
		$name  = $args['label_for'];
		$class = $args['class'];

		// initialize input's name like 'option_name[cpt_manager]'
		$option_name = $args['option_name'];
		$checkbox    = get_option( $option_name );
		// if there was an option with the option_name ($checkbox), then if there was an option with option_name value check the checkbox
		$checked = $checkbox ? ( $checkbox[ $name ] ? 'checked' : '' ) : '';

		echo "<input type='checkbox' id='$name' name='$option_name" . "[$name]' value='1' class='$class' $checked><label for='$name'></label>";
	}
}