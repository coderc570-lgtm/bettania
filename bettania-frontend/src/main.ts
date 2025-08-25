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

AOS.init({
  once: false,
  duration: 800,
  easing: 'ease-out-back',
  mirror: true,
});

router.afterEach(() => {
  setTimeout(() => {
    AOS.refreshHard();
  }, 100);
});


router.afterEach((to) => {
  // Update AOS animations
  setTimeout(() => {
    AOS.refreshHard();
  }, 100);

  // Update document title
  if (to.meta?.title) {
    document.title = to.meta.title as string;
  } else {
    document.title = 'Bettania'; // Default fallback
  }
});
