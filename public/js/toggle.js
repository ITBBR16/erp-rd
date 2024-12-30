var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
var themeToggleBtn = document.getElementById('theme-toggle');

enableLightMode();

themeToggleBtn.addEventListener('click', function() {
    if (document.documentElement.classList.contains('dark')) {
        enableLightMode();
    } else {
        enableDarkMode();
    }
});

function enableDarkMode() {
    document.documentElement.classList.add('dark');
    themeToggleDarkIcon.classList.add('hidden');
    themeToggleLightIcon.classList.remove('hidden');
}

function enableLightMode() {
    document.documentElement.classList.remove('dark');
    themeToggleDarkIcon.classList.remove('hidden');
    themeToggleLightIcon.classList.add('hidden');
}
