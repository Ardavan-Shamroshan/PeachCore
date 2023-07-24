<?php

namespace Inc\Controllers;

use Inc\Api\Callbacks\TestimonialCallbacks;
use Inc\Api\Settings;

class TestimonialController extends BaseController {
	public Settings $settings;
	public TestimonialCallbacks $testimonial_callbacks;

	public function register() {
		if ( ! $this->activated( 'testimonial_manager' ) ) {
			return;
		}

		$this->settings              = new Settings;
		$this->testimonial_callbacks = new TestimonialCallbacks;

		add_action( 'init', array( $this, 'testimonial_custom_post_type' ) );

		add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
		add_action( 'save_post', [ $this, 'save_meta_box' ] );
//		add_action( 'manage_{post_type}_posts_columns');
		add_action( 'manage_testimonial_posts_columns', [ $this, 'set_custom_columns' ] );
		add_action( 'manage_testimonial_posts_custom_column', [ $this, 'set_custom_columns_data' ], 10, 2 );
		add_filter( 'manage_edit-testimonial_sortable_columns', [ $this, 'set_custom_columns_sortable' ] );

		$this->set_short_code_page();
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

	public function set_custom_columns( $columns ) {
		$title = $columns['title'];
		$date  = $columns['data'];

		unset( $columns['title'], $columns['data'] );

		$columns['name']     = 'نام نویسنده';
		$columns['title']    = $title;
		$columns['approved'] = 'تایید شده';
		$columns['featured'] = 'ویژه';
		$columns['date']     = $date;

		return $columns;
	}

	public function set_custom_columns_data( $column, $post_id ) {

		$data     = get_post_meta( $post_id, '_peach_core_testimonial_key', true );
		$name     = $data['name'] ?? '';
		$email    = $data['email'] ?? '';
		$approved = isset( $data['approved'] ) && $data['approved'] === 1 ? '<strong>بله</strong>' : 'خیر';
		$featured = isset( $data['featured'] ) && $data['featured'] === 1 ? '<strong>بله</strong>' : 'خیر';


		switch ( $column ) {
			case 'name':
				echo '<strong>' . $name . '</strong><br/><a href="mailto:' . $email . '">' . $email . '</a>';
				break;

			case 'approved':
				echo $approved;
				break;

			case 'featured':
				echo $featured;
				break;
		}
	}

	public function set_custom_columns_sortable( $columns ) {
		$columns['name']     = 'name';
		$columns['approved'] = 'approved';
		$columns['featured'] = 'featured';

		return $columns;
	}

	public function set_short_code_page() {
		$subpage = [
			[
				'parent_slug' => 'edit.php?post_type=testimonial',
				'page_title'  => 'کد های کوتاه',
				'menu_title'  => 'کد های کوتاه',
				'capability'  => 'manage_options',
				'menu_slug'   => 'peach_core_testimonial_shortcode',
				'callback'    => [ $this->testimonial_callbacks, 'shortcode_page' ]
			]
		];

		$this->settings->add_subpages( $subpage )->register();
	}
}