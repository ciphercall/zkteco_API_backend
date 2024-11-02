import { createApp } from 'vue';
import RegisterPage from './components/RegisterPage.vue';
import LoginPage from './components/LoginPage.vue';

const app = createApp({});
app.component('register-page', RegisterPage);
app.component('login-page', LoginPage);
app.mount('#app');
app.config.errorHandler = (err) => {
    console.error("Vue Error:", err);
};
