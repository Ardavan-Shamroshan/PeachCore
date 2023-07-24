<?php

namespace Inc\Api\Widgets;

use WP_Widget;

class MediaWidget extends WP_Widget {
	public $widget_ID;
	public $widget_name;
	public $widget_options = [];
	public $control_options = [];

	public function register() {
		parent::__construct( $this->widget_ID, $this->widget_name, $this->widget_options, $this->control_options );

		add_action( 'widgets_init', [ $this, 'widget_init' ] );
	}

	public function __construct() {
		$this->widget_ID       = 'peach_core_widget';
		$this->widget_name     = 'ابزارک هسته هلو';
		$this->widget_options  = [
			'classname'                   => $this->widget_ID,
			'description'                 => $this->widget_name,
			'customize_selective_refresh' => true,

		];
		$this->control_options = [
			'width'  => 400,
			'height' => 350,
		];
	}

	public function widget_init() {
		register_widget( $this );
	}

	// do not change these three methods names

	// widget
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		echo $args['after_widget'];
	}

	// form
	public function form( $instance ) {
		$title      = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'عنوان تستی', 'peach_core_plugin' );
		$title_ID   = esc_attr( $this->get_field_id( "title" ) );
		$title_name = esc_attr( $this->get_field_name( "title" ) );
		?>
        <p><label for="<?= $title_ID ?>">عنوان</label></p>
        <input type="text" class="widefat" id="<?= $title_ID ?>" name="<?= $title_name ?>" value="<?= esc_attr( $title ) ?>">
		<?php


	}

	// update
	public function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );

		return $instance;
	}

}