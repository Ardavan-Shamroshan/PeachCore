<?php

namespace Inc\Controllers;

class TestimonialController extends BaseController {
	public function register() {
		if ( ! $this->activated( 'testimonial_manager' ) ) {
			return;
		}

		add_action( 'init', array( $this, 'testimonial_custom_post_type' ) );

		add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );

		add_action( 'save_post', [ $this, 'save_meta_box' ] );

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

	public function add_meta_boxes() {
		add_meta_box(
			'testimonial_author',
			'تنظیمات گواهی',
			array( $this, 'render_features_box' ),
			'testimonial',
			'side',
			'default'
		);

		//
	}

	public function render_features_box( $post ) {
		wp_nonce_field( 'peach_core_testimonial', 'peach_core_testimonial_nonce' );


		$data     = get_post_meta( $post->ID, '_peach_core_testimonial_key', true );
		$name     = $data['name'] ?? '';
		$email    = $data['email'] ?? '';
		$approved = $data['approved'] ?? false;
		$featured = $data['featured'] ?? false;
		?>
        <p>
            <label class="meta-label" for="peach_core_testimonial_author">نام نویسنده</label>
            <input type="text" id="peach_core_testimonial_author" name="peach_core_testimonial_author" class="widefat" value="<?php echo esc_attr( $name ); ?>">
        </p>
        <p>
            <label class="meta-label" for="peach_core_testimonial_email">ایمیل نویسنده</label>
            <input type="email" id="peach_core_testimonial_email" name="peach_core_testimonial_email" class="widefat" value="<?php echo esc_attr( $email ); ?>">
        </p>
        <div class="meta-container">
            <div class="text-right w-50 inline-block">
                <div class="ui-toggle inline"><input type="checkbox" id="peach_core_testimonial_approved" name="peach_core_testimonial_approved" value="1" <?php echo $approved ? 'checked' : ''; ?>>
                    <label for="peach_core_testimonial_approved"></label>
                </div>
            </div>
            <label class="meta-label w-50 text-left" for="peach_core_testimonial_approved">تایید شده؟</label>
        </div>
        <div class="meta-container">
            <div class="text-right w-50 inline-block">
                <div class="ui-toggle inline"><input type="checkbox" id="peach_core_testimonial_featured" name="peach_core_testimonial_featured" value="1" <?php echo $featured ? 'checked' : ''; ?>>
                    <label for="peach_core_testimonial_featured"></label>
                </div>
            </div>
            <label class="meta-label w-50 text-left" for="peach_core_testimonial_featured">ویژه؟</label>
        </div>
		<?php
	}

	public function render_author_box( $post ) {
		wp_nonce_field( 'peach_core_testimonial', 'peach_core_testimonial_nonce' );


		$value = get_post_meta( $post->ID, '_peach_core_testimonial_key', true );
		?>

        <label for="peach_core_testimonial">نویسنده گواهی</label>
        <input type="text" id="peach_core_testimonial" name="peach_core_testimonial" value="<?= esc_attr( $value ) ?>">

		<?php
	}

	public function save_meta_box( $post_id ) {
		// if it was not in testimonial section , return and don't do anything
		if ( ! isset( $_POST['peach_core_testimonial_nonce'] ) ) {
			return $post_id;
		}

		// should get the proper and expecting nonce
		$nonce = $_POST['peach_core_testimonial_nonce'];
		if ( ! wp_verify_nonce( $nonce, 'peach_core_testimonial' ) ) {
			return $post_id;
		}

		// other save options will not get interrupted
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}


		// user should have the permission
		if ( current_user_can( "edit_post . $post_id" ) ) {
			return $post_id;
		}

		$data = [
			'name'     => sanitize_text_field( $_POST['peach_core_testimonial_author'] ),
			'email'    => sanitize_text_field( $_POST['peach_core_testimonial_email'] ),
			'approved' => isset( $_POST['peach_core_testimonial_approved'] ) ? 1 : 0,
			'featured' => isset( $_POST['peach_core_testimonial_featured'] ) ? 1 : 0,
		];
		update_post_meta( $post_id, '_peach_core_testimonial_key', $data );

	}
}