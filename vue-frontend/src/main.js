import { createApp } from 'vue';
import App from './App.vue';
import router from './plugins/router';

// Import Bootstrap CSS
import 'bootstrap/dist/css/bootstrap.min.css';

// Import Bootstrap JS
import 'bootstrap/dist/js/bootstrap.bundle.min';

createApp(App)
    .use(router)
    .mount('#app');
