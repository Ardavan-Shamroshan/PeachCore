<div class="wrap">
    <h1>نوع پست اختصاصی</h1>
	<?php settings_errors(); ?>

    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-1">لیست انواع پست های اختصاصی</a></li>
        <li><a href="#tab-2">ایجاد نوع پست اختصاصی</a></li>
        <li><a href="#tab-3">استخراج</a></li>
    </ul>

    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <h3>لیست پست ها</h3>
			<?php $options = get_option( 'peach_core_plugin_cpt' ); ?>

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
				<?php foreach ( $options as $option ): ?>
                    <tr>
                        <td><?= $option['post_type'] ?></td>
                        <td><?= $option['name'] ?></td>
                        <td><?= $option['singular_name'] ?></td>
                        <td><?= $option['public'] ?></td>
                        <td><?= $option['has_archive'] ?></td>
                        <td class="text-center"><a href="#">ویرایش</a> - <a href="#">حذف</a></td>
                    </tr>
				<?php endforeach; ?>
                </tbody>
            </table>

        </div>

        <div id="tab-2" class="tab-pane">

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