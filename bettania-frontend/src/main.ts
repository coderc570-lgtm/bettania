// main.ts
import { createApp } from 'vue';
import App from '@/App.vue';
import pinia from '@/store/store';
import './assets/index.css';
import router from '@/router';
import axiosPlugin from '@/axios/axios';
import notifications from '@kyvg/vue3-notification';
import { useAuthStore } from '@/store/authLogin';
import '@fortawesome/fontawesome-free/css/all.css';
import AOS from 'aos'
import 'aos/dist/aos.css'
import 'remixicon/fonts/remixicon.css'
import './assets/fonts.css';

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

// ✅ Initialize AOS after mounting
AOS.init({
  once: true, // run only once per element
  duration: 800, // animation duration in ms
});

// 🔁 Optional: re-init AOS on route change (useful for SPA)
router.afterEach(() => {
  AOS.refresh();
});
