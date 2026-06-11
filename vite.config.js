import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'
export default defineConfig({
    plugins: [
        laravel({
            input: [
                // CSS
                'resources/css/app.css',
                'resources/css/category.css',
                'resources/css/globalcss.css',
                'resources/css/index.css',
                'resources/css/pageOff.css',
                'resources/css/perfil.css',
                'resources/css/resumoCompra.css',
                'resources/css/styleAdm.css',
                'resources/css/styleLoginRegister.css',
                'resources/css/telaDeCompra.css',
                // JS
                'resources/js/admin.js',
                'resources/js/app.js',
                'resources/js/bootstrap.js',
                'resources/js/cards.js',
                'resources/js/filtro.js',
                'resources/js/index.js',
                'resources/js/loading.js',
                'resources/js/login.js',
                'resources/js/navbar.js',
                'resources/js/popup.js',
                'resources/js/telaDeCompra.js',
                'resources/js/twoFactor.js',
            ],
            refresh: true,
        }),
        tailwindcss()
    ],
});