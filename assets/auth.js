document.addEventListener('DOMContentLoaded', function (e) {
    const showAuthBtn = document.getElementById('peach-core-show-auth-form'),
        authContainer = document.getElementById('peach-core-auth-container'),
        close = document.getElementById('peach-core-auth-close'),
        authForm = document.getElementById('peach-core-auth-form'),
        status = authForm.querySelector('[data-message="status"]');


    showAuthBtn
        .addEventListener('click', () => {
            authContainer.classList.add('show');
            showAuthBtn.parentElement.classList.add('hide');
        });

    close.addEventListener('click', () => {
        authContainer.classList.remove('show');
        showAuthBtn.parentElement.classList.remove('hide');
    });

    // do the login
    authForm.addEventListener('submit', e => {
        e.preventDefault();

        // reset message
        resetMessage();

        // collect the form data
        let data = {
            name: authForm.querySelector('[name="username"]').value,
            password: authForm.querySelector('[name="password"]').value,
            nonce: authForm.querySelector('[name="peach_core_auth"]').value,
        }

        // validate
        if (!data.name || !data.password) {
            status.innerHTML = 'لطفا همه موارد را پر کنید';
            status.classList.add('error');
        }

        // ajax http post request
        let url = authForm.dataset.url;
        let params = new URLSearchParams(new FormData(authForm));

        authForm.querySelector('[name="submit"]').value = 'درحال ارسال...';
        authForm.querySelector('[name="submit"]').disabled = true;

        fetch(url, {
            method: "POST",
            body: params,
        }).then(res => res.json())
            .catch(error => {
                resetMessage();
            })
            .then(response => {
                resetMessage();

                // if failed
                if (response === 0 || !response.status) {
                    status.innerHTML = response.message;
                    status.classList.add('error');
                    return;
                }

                // success
                status.innerHTML = response.message;
                status.classList.add('success');
                authForm.reset();

                window.location.reload();
            });
    });

    function resetMessage() {
        status.innerHTML = '';
        status.classList.remove('success', 'error');

        authForm.querySelector('[name="submit"]').value = 'ورود';
        authForm.querySelector('[name="submit"]').disabled = false;
    }
});