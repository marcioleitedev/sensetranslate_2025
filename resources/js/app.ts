import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import 'bootstrap/dist/css/bootstrap.min.css'; // Importa os estilos do Bootstrap
import 'bootstrap/dist/js/bootstrap.bundle.min.js'; // Importa os scripts do Bootstrap

createInertiaApp({
    resolve: name => import(`./Pages/${name}.vue`), // Aponta para resources/js/Pages/
    setup({ el, App, props }) {
        createApp({ render: () => h(App, props) }).mount(el);
    },
});
