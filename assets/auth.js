document.addEventListener('DOMContentLoaded', function (e) {
    const showAuthBtn = document.getElementById('peach-core-show-auth-form'),
        authContainer = document.getElementById('peach-core-auth-container'),
        close = document.getElementById('peach-core-auth-close');


    showAuthBtn.addEventListener('click', () => {
        authContainer.classList.add('show');
        showAuthBtn.parentElement.classList.add('hide');
    });

    close.addEventListener('click', () => {
        authContainer.classList.remove('show');
        showAuthBtn.parentElement.classList.remove('hide');
    });
});