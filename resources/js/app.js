import { createApp } from 'vue';
import RegisterPage from './components/RegisterPage.vue';
import LoginPage from './components/LoginPage.vue';
import DevicePage from './components/DevicePage.vue';
import AttendanceLogsPage from './components/AttendanceLogsPage.vue';
import RegisteredUsersPage from './components/RegisteredUsersPage.vue';

const app = createApp({});
app.component('register-page', RegisterPage);
app.component('login-page', LoginPage);
app.component('device-page', DevicePage);
app.component('attendance-logs-page', AttendanceLogsPage);
app.component('registered-users-page', RegisteredUsersPage);
app.mount('#app');
app.config.errorHandler = (err) => {
    console.error("Vue Error:", err);
};
