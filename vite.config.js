import { fileURLToPath, URL } from 'node:url'
import { defineConfig } from 'vite';

import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/src/main.js'],
            refresh: true,
        }),
        tailwindcss(),
        vue({
            template: {
                transformAssetUrls: {
                    // The Vue plugin will re-write asset URLs, when referenced
                    // in Single File Components, to point to the Laravel web
                    // server. Setting this to `null` allows the Laravel plugin
                    // to instead re-write asset URLs to point to the Vite
                    // server instead.
                    base: null,
                }
            }
        })
    ],
    
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
            '@': fileURLToPath(new URL('./resources/js/src', import.meta.url))
        },
        
    },
});
