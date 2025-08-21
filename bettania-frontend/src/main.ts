// main.ts
import { createApp } from 'vue';
import App from '@/App.vue';
import pinia from '@/store/store';
import './assets/index.css';
import router from '@/router';
import axiosPlugin from '@/axios/axios';
import notifications from '@kyvg/vue3-notification';
import { useAuthStore } from '@/store/authLogin';

const app = createApp(App);

// Register plugins
app.use(pinia);
app.use(router);
app.use(axiosPlugin);
app.use(notifications);

// Extend Pinia with the $notify property
pinia.use(({ store }) => {
  store.$notify = app.config.globalProperties.$notify;
});

const authStore = useAuthStore();
authStore.checkAuth();

// Mount the app
app.mount('#app');
