import { createApp } from 'vue';
import App from './App.vue';
import router from './plugins/router';
import axios from './plugins/axios';
import i18n from './plugins/i18n'

import { createPinia } from 'pinia'

// Import Bootstrap JS
import 'bootstrap/dist/js/bootstrap.bundle.min';

// Import own design
import './assets/styles/main.scss';

const pinia = createPinia()

createApp(App)
    .use(axios)
    .use(router)
    .use(pinia)
    .use(i18n)
    .mount('#app');
