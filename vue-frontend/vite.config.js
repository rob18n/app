import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import { resolve } from 'path';
import path from 'path';

export default defineConfig({
    plugins: [vue()],
    resolve: {
        alias: {
            '@': resolve(__dirname, 'src'),
            'bootstrap': path.resolve(__dirname, 'node_modules/bootstrap')
        },
    },
    server: {
        port: 3112,
        host: true, // Erlaube den Zugriff von anderen Geräten im Netzwerk
    },
});
