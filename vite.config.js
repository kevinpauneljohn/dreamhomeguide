import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/css/properties.css',
                'resources/css/dashboard.css',
                'resources/js/app.js',
                'resources/js/dashboard/app.js',
                'resources/js/dashboard/permission-table.js',
                'resources/js/property-gallery.js',
                'resources/js/dashboard/properties.js',
                'resources/js/dashboard/add-property.js',
                'resources/js/dashboard/dashboard.js'
            ],
            refresh: true,
        }),
    ],
});
