import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/scss/navigation.scss',
                'resources/js/app.js',
                'resources/js/navigation.js',
                'resources/scss/welcome.scss',
                'resources/js/welcome.js',
                'resources/scss/dashboard.scss',
                'resources/scss/auth-app.scss',
                'resources/js/dashboard.js',
                'resources/scss/election.scss', 
                'resources/js/election.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
    },
});