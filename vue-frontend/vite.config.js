import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import { resolve } from 'path';
import path from 'path';
import Components from 'unplugin-vue-components/vite';
import VueIconsResolver from '@kalimahapps/vue-icons/resolver';

export default defineConfig({
    plugins: [
        vue(),
        Components({
            resolvers: [
                VueIconsResolver,
            ],
        })
    ],
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
