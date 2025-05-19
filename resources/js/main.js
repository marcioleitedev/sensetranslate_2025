// main.js ou main.ts
import { createApp } from 'vue';
import App from './App.vue';
import router from './router'; // Certifique-se de que o roteador está importado

const app = createApp(App);
app.use(router); // Adicione o roteador ao aplicativo Vue
app.mount('#app');