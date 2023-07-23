<div class="wrap">
    <h1>دسته بندی اختصاصی</h1>

    <ul class="nav nav-tabs">
        <li class="<?= ! isset( $_POST['edit_taxonomy'] ) ? 'active' : '' ?>"><a href="#tab-1">لیست دسته بندی های اختصاصی</a></li>
        <li class="<?= isset( $_POST['edit_taxonomy'] ) ? 'active' : '' ?>"><a href="#tab-2"><?= isset( $_POST['edit_taxonomy'] ) ? 'ویرایش دسته بندی اختصاصی' : 'ایجاد دسته بندی اختصاصی' ?></a></li>
        <li><a href="#tab-3">استخراج</a></li>
    </ul>

    <div class="tab-content">
        <div id="tab-1" class="tab-pane <?= ! isset( $_POST['edit_taxonomy'] ) ? 'active' : '' ?>">
            <h3>لیست دسته بندی ها</h3>
			<?php $options = get_option( 'peach_core_plugin_taxonomy' ) ?: []; ?>

            <table class="cpt-table">
                <tr>
                    <th>شناسه</th>
                    <th>نام مفرد</th>
                    <th>سلسله مراتب</th>
                    <th class="text-center">عملیات</th>
                </tr>
                <tbody>
				<?php foreach ( $options as $option ):
					$hierarchical = isset( $option['hierarchical'] ) ? 'فعال' : 'غیرفعال';
					?>
                    <tr>
                        <td><?= $option['taxonomy'] ?></td>
                        <td><?= $option['singular_name'] ?></td>
                        <td><?= $hierarchical ?></td>
                        <td class="text-center">
                            <form action="options.php" method="post" class=" inline-block">
                                <input type="hidden" name="remove" value="<?= $option['taxonomy'] ?>">
								<?php
								settings_fields( 'peach_core_plugin_taxonomy_settings' );
								submit_button( 'پاک کردن', 'delete small', 'submit', false, [ 'onclick' => 'return confirm("از پاک کردن داده مورد نظر اطمینان دارید؟ تمامی اطلاعات از بین خواهند رفت.");' ] );
								?>
                            </form>
                            <form action="" method="post" class=" inline-block">
                                <input type="hidden" name="edit_taxonomy" value="<?= $option['taxonomy'] ?>">
								<?php
								settings_fields( 'peach_core_plugin_taxonomy_settings' );
								submit_button( 'ویرایش', 'primary small', 'submit', false );
								?>
                            </form>
                        </td>
                    </tr>
				<?php endforeach; ?>
                </tbody>
            </table>

        </div>

        <div id="tab-2" class="tab-pane <?= isset( $_POST['edit_taxonomy'] ) ? 'active' : '' ?>">
            <form action="options.php" method="POST">
				<?php
				settings_fields( 'peach_core_plugin_taxonomy_settings' );
				do_settings_sections( 'peach-core-custom-taxonomy-submenu' );
				submit_button();
				?>
            </form>
        </div>
        <div id="tab-3" class="tab-pane">
            <h3>استخراج</h3>

        </div>
    </div>

</div>