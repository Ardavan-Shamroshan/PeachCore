<div class="wrap">
    <h1>نوع پست اختصاصی</h1>

    <ul class="nav nav-tabs">
        <li class="<?= ! isset( $_POST['edit_post'] ) ? 'active' : '' ?>"><a href="#tab-1">لیست انواع پست های اختصاصی</a></li>
        <li class="<?= isset( $_POST['edit_post'] ) ? 'active' : '' ?>"><a href="#tab-2"><?= isset( $_POST['edit_post'] ) ? 'ویرایش نوع پست اختصاصی' : 'ایجاد نوع پست اختصاصی' ?></a></li>
        <li><a href="#tab-3">استخراج</a></li>
    </ul>

    <div class="tab-content">
        <div id="tab-1" class="tab-pane <?= !isset( $_POST['edit_post'] ) ? 'active' : '' ?>">
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
                            <form action="options.php" method="post" class=" inline-block">
                                <input type="hidden" name="remove" value="<?= $option['post_type'] ?>">
								<?php
								settings_fields( 'peach_core_plugin_cpt_settings' );
								submit_button( 'پاک کردن', 'delete small', 'submit', false, [ 'onclick' => 'return confirm("از پاک کردن داده مورد نظر اطمینان دارید؟ تمامی اطلاعات از بین خواهند رفت.");' ] );
								?>
                            </form>
                            <form action="" method="post" class=" inline-block">
                                <input type="hidden" name="edit_post" value="<?= $option['post_type'] ?>">
								<?php
								settings_fields( 'peach_core_plugin_cpt_settings' );
								submit_button( 'ویرایش', 'primary small', 'submit', false );
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
        </div>
    </div>

</div>