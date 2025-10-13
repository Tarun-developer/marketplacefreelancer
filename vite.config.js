import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
     plugins: [
         laravel({
             input: ['resources/css/app.css', 'resources/js/app.js'],
             refresh: true,
         }),
         {
             name: 'alpine',
             entry: 'node_modules/alpinejs/dist/cdn.min.js',
         },
         {
             name: 'dropzone',
             entry: 'node_modules/dropzone/dist/min/dropzone.min.js',
         },
         {
             name: 'browser-image-compression',
             entry: 'node_modules/browser-image-compression/dist/browser-image-compression.js',
         },
         tailwindcss(),
     ],
});
