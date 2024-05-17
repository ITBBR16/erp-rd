document.addEventListener("DOMContentLoaded", function () {
    const loader = document.getElementById('loader');
    const form = document.querySelector('form');

    form.addEventListener('submit', function () {
        loader.style.display = 'block';
    });
});