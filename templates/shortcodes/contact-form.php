<form id="peach-core-testimonial-form" action="#" method="post" data-url="<?= admin_url('admin-ajax.php'); ?>">

    <div class="field-container">
        <input type="text" class="field-input" placeholder="Your Name" id="name" name="name" required>
        <small class="field-msg error" data-error="invalidName">نام الزامی است</small>
    </div>

    <div class="field-container">
        <input type="email" class="field-input" placeholder="Your Email" id="email" name="email" required>
        <small class="field-msg error" data-error="invalidEmail">ایمیل معتبر نیست</small>
    </div>

    <div class="field-container">
        <textarea name="message" id="message" class="field-input" placeholder="Your Message" required></textarea>
        <small class="field-msg error" data-error="invalidMessage">پیغام الزامی است</small>
    </div>

    <div class="field-container">
        <div>
            <button type="stubmit" class="btn btn-default btn-lg btn-sunset-form">فرستادن</button>
        </div>
        <small class="field-msg js-form-submission">درحال ارسال&hellip;</small>
        <small class="field-msg success js-form-success">پیام شما با موفقیت ارسال شد. سپاس از شما</small>
        <small class="field-msg error js-form-error">مشکلی بوجود آمده است، دوباره تلاش کنید</small>
    </div>

    <input type="hidden" name="action" value="submit_testimonial">
    <input type="hidden" name="nonce" value="<?= wp_create_nonce("testimonial-nonce") ?>">

</form>