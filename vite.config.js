import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/js/kios/app.js',
                'resources/js/repair/app.js',
                'resources/js/logistik/app.js',
                'resources/js/gudang/app.js',
            ],
            refresh: true,
        }),
    ],
});
