import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/clients/app.css',
                'resources/js/clients/app.js',
                'resources/css/admin/app.css',
                'resources/js/admin/app.js',
            ],
            refresh: true,
            fonts: [
                bunny('Open Sans', {
                    weights: [300, 400, 500, 600, 700, 800],
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
