<div class="wrap">
    <h1>نوع پست اختصاصی</h1>

	<?php settings_errors() ;?>

    <ul class="nav nav-tabs">
        <li class="<?= ! isset( $_POST['edit_post'] ) ? 'active' : '' ?>"><a href="#tab-1">لیست انواع پست های اختصاصی</a></li>
        <li class="<?= isset( $_POST['edit_post'] ) ? 'active' : '' ?>"><a href="#tab-2"><?= isset( $_POST['edit_post'] ) ? 'ویرایش نوع پست اختصاصی' : 'ایجاد نوع پست اختصاصی' ?></a></li>
        <li><a href="#tab-3">استخراج</a></li>
    </ul>

    <div class="tab-content">
        <div id="tab-1" class="tab-pane <?= ! isset( $_POST['edit_post'] ) ? 'active' : '' ?>">
            <h3>لیست پست ها</h3>
			<?php $options = get_option( 'peach_core_plugin_cpt' ) ?: []; ?>

            <table class="cpt-table">
                <tr>
                    <th>شناسه</th>
                    <th>نام</th>
                    <th>نام مفرد</th>
                    <th>عمومی</th>
                    <th>دارای آرشیو</th>
                    <th class="text-center">عملیات</th>
                </tr>
                <tbody>
				<?php foreach ( $options as $option ):
					$public = isset( $option['public'] ) ? 'فعال' : 'غیرفعال';
					$has_archive = isset( $option['has_archive'] ) ? 'فعال' : 'غیرفعال';
					?>
                    <tr>
                        <td><?= $option['post_type'] ?></td>
                        <td><?= $option['name'] ?></td>
                        <td><?= $option['singular_name'] ?></td>
                        <td><?= $public ?></td>
                        <td><?= $has_archive ?></td>
                        <td class="text-center">
                            <form action="" method="post" class=" inline-block">
                                <input type="hidden" name="edit_post" value="<?= $option['post_type'] ?>">
		                        <?php
		                        settings_fields( 'peach_core_plugin_cpt_settings' );
		                        submit_button( 'ویرایش', 'primary small', 'submit', false );
		                        ?>
                            </form>
                            <form action="options.php" method="post" class=" inline-block">
                                <input type="hidden" name="remove" value="<?= $option['post_type'] ?>">
								<?php
								settings_fields( 'peach_core_plugin_cpt_settings' );
								submit_button( 'پاک کردن', 'delete small', 'submit', false, [ 'onclick' => 'return confirm("از پاک کردن داده مورد نظر اطمینان دارید؟ تمامی اطلاعات از بین خواهند رفت.");' ] );
								?>
                            </form>
                        </td>
                    </tr>
				<?php endforeach; ?>
                </tbody>
            </table>

        </div>

        <div id="tab-2" class="tab-pane <?= isset( $_POST['edit_post'] ) ? 'active' : '' ?>">

            <form action="options.php" method="POST">
				<?php
				settings_fields( 'peach_core_plugin_cpt_settings' );
				do_settings_sections( 'peach-core-custom-post-type-submenu' );
				submit_button();
				?>
            </form>
        </div>
        <div id="tab-3" class="tab-pane">
            <h3>استخراج</h3>

            <?php foreach($options as $option) : ?>

            <h3><?= $option['singular_name'] ?></h3>

            <pre class="prettyprint lang-scm" dir="ltr">
                // Register Custom Post Type
                function custom_post_type() {

                    $labels = array(
                        'name'                  => _x( '<?= $option['name'] ?>', 'Post Type General Name', 'text_domain' ),
                        'singular_name'         => _x( '<?= $option['singular_name'] ?>', 'Post Type Singular Name', 'text_domain' ),
                        'menu_name'             => __( '<?= $option['singular_name'] ?>', 'text_domain' ),
                        'name_admin_bar'        => __( 'Post Type', 'text_domain' ),
                        'archives'              => __( 'Item Archives', 'text_domain' ),
                        'attributes'            => __( 'Item Attributes', 'text_domain' ),
                        'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
                        'all_items'             => __( 'All Items', 'text_domain' ),
                        'add_new_item'          => __( 'Add New Item', 'text_domain' ),
                        'add_new'               => __( 'Add New', 'text_domain' ),
                        'new_item'              => __( 'New Item', 'text_domain' ),
                        'edit_item'             => __( 'Edit Item', 'text_domain' ),
                        'update_item'           => __( 'Update Item', 'text_domain' ),
                        'view_item'             => __( 'View Item', 'text_domain' ),
                        'view_items'            => __( 'View Items', 'text_domain' ),
                        'search_items'          => __( 'Search Item', 'text_domain' ),
                        'not_found'             => __( 'Not found', 'text_domain' ),
                        'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
                        'featured_image'        => __( 'Featured Image', 'text_domain' ),
                        'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
                        'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
                        'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
                        'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
                        'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
                        'items_list'            => __( 'Items list', 'text_domain' ),
                        'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
                        'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
                    );
                    $args = array(
                        'label'                 => __( 'Post Type', 'text_domain' ),
                        'description'           => __( 'Post Type Description', 'text_domain' ),
                        'labels'                => $labels,
                        'supports'              => false,
                        'taxonomies'            => array( 'category', 'post_tag' ),
                        'hierarchical'          => false,
                        'public'                => <?= isset( $option['public'] ) ? 'true' : 'false' ?>,
                        'show_ui'               => true,
                        'show_in_menu'          => true,
                        'menu_position'         => 5,
                        'show_in_admin_bar'     => true,
                        'show_in_nav_menus'     => true,
                        'can_export'            => true,
                        'has_archive'           => <?= isset( $option['has_archive'] ) ? 'true' : 'false' ?>,
                        'exclude_from_search'   => false,
                        'publicly_queryable'    => true,
                        'capability_type'       => 'page',
                    );
                    register_post_type( '<?= $option['post_type'] ?>', $args );

                }
                add_action( 'init', 'custom_post_type', 0 );
            </pre>

            <?php endforeach;  ?>
        </div>
    </div>

</div>