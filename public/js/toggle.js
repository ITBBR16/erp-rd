var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
var themeToggleBtn = document.getElementById('theme-toggle');

// Cek jika dark mode sudah ada di local storage atau tidak
if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    enableDarkMode();
} else {
    enableLightMode();
}

// Toggle mengganti dark mode
themeToggleBtn.addEventListener('click', function() {
    if (document.documentElement.classList.contains('dark')) {
        enableLightMode();
    } else {
        enableDarkMode();
    }
});

function enableDarkMode() {
    document.documentElement.classList.add('dark');
    localStorage.setItem('color-theme', 'dark');
    themeToggleDarkIcon.classList.add('hidden');
    themeToggleLightIcon.classList.remove('hidden');
}

function enableLightMode() {
    document.documentElement.classList.remove('dark');
    localStorage.setItem('color-theme', 'light');
    themeToggleDarkIcon.classList.remove('hidden');
    themeToggleLightIcon.classList.add('hidden');
}
