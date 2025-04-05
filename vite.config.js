import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css',
                'resources/js/app.js',
                'resources/css/style.css',
                'resources/css/sidebars.css',
                'resources/js/appLayoutPanel.js',
                'resources/js/showFormU.js',
                'resources/js/theme.js',
            ],
            refresh: true,
        }),
    ],
});
