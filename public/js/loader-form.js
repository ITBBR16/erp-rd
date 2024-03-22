document.addEventListener("DOMContentLoaded", function () {
    const submitButtons = document.querySelectorAll('.submit-button-form');
    const loaders = document.querySelectorAll('.loader-button-form');

    submitButtons.forEach((button, index) => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            button.style.display = 'none';
            loaders[index].style.display = 'block';

            const form = button.closest('form');
            form.submit();
        });
    });
});
