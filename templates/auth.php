<form id="peach-core-auth-form" action="#" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>">
    <div class="auth-btn">
        <input class="submit_button" type="button" value="ورود" id="peach-core-show-auth-form">
    </div>
    <div id="peach-core-auth-container" class="auth-container">
        <a id="peach-core-auth-close" class="close" href="#">&times;</a>
        <br>
        <h2>ورود</h2>
        <label for="username">نام کاربری</label>
        <input id="username" type="text" name="username"><br>
        <label for="password">کلمه عبور</label>
        <input id="password" type="password" name="password">
        <input class="submit_button" type="submit" value="ورود" name="submit">
        <p class="status"></p>

        <p class="actions">
            <a href="<?php echo wp_lostpassword_url(); ?>">کلمه عبور خود را فراموش کرده اید؟</a> - <a href="<?php echo wp_registration_url(); ?>">ثبت نام</a>
        </p>

		<?php wp_nonce_field( 'ajax-login-nonce', 'peach_core_auth' ); ?>
    </div>
</form>