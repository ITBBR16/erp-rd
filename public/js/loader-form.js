document.addEventListener("DOMContentLoaded", function () {
    const submitButtons = document.querySelectorAll('.submit-button-form');
    const loaders = document.querySelectorAll('.loader-button-form');

    submitButtons.forEach((button, index) => {
        button.addEventListener('click', function (event) {
            const form = button.closest('form');
            if (form.checkValidity()) {
                event.preventDefault();
                button.style.display = 'none';
                loaders[index].style.display = 'block';
                form.submit();
            } else {
                form.reportValidity();
            }
        });
    });

    document.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
        }
    });
});
