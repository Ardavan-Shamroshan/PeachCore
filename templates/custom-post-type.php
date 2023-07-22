<div class="wrap">
    <h1>نوع پست اختصاصی</h1>
	<?php settings_errors(); ?>


    <form action="options.php" method="POST">
		<?php
		settings_fields( 'peach_core_plugin_cpt_settings' );
		do_settings_sections( 'peach-core-custom-post-type-submenu' );
		submit_button();
		?>
    </form>
</div>