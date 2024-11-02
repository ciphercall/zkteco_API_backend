import { createApp } from 'vue';
import RegisterPage from './components/RegisterPage.vue';
import LoginPage from './components/LoginPage.vue';
import DevicePage from './components/DevicePage.vue';

const app = createApp({});
app.component('register-page', RegisterPage);
app.component('login-page', LoginPage);
app.component('device-page', DevicePage);
app.mount('#app');
app.config.errorHandler = (err) => {
    console.error("Vue Error:", err);
};
