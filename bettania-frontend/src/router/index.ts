import { createMemoryHistory, createRouter  } from 'vue-router'
import { useAuthStore } from '@/store/authLogin';
import UserLogin from '@/components/UserLogin.vue';
import HomePage from '@/components/HomePage.vue';
import SignUp from '@/components/SignUp.vue';
import ProfileSettings from '@/components/ProfileSettings.vue';
import CreateEvent from '@/components/CreateEvent.vue';
import Contact from '@/components/Contact.vue';
import CustomSuit from '@/components/CustomSuit.vue';

const routes = [
  {
    path: '/',
    component: HomePage,
    name: 'home'
  },

  {
    path: '/login',
    component: UserLogin,
    name: 'login', 
  },

  {
    path: '/register',
    component: SignUp,
    name: 'register',
  },

  { 
    path: '/create-event',
    component: CreateEvent, 
    name: 'create-event',
  },

  { 
    path: '/profile',
    component: ProfileSettings, 
    name: 'profile',
    meta: { requiresAuth: true} 
  },

  { 
    path: '/contact',
    component: Contact, 
    name: 'contact',
  },

  { 
    path: '/custom-suit',
    component: CustomSuit, 
    name: 'custom-suit',
  },
]

const router = createRouter({
  history: createMemoryHistory(),
  routes,
});

router.beforeEach(async (to, from, next) => {
  const authStore = useAuthStore();

  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!authStore.isLoggedIn) {
      try {
        await authStore.checkAuth();
        if (!authStore.isLoggedIn) {
          next({ name: 'login' });
        } else {
          next();
        }
      } catch (error) {
        next({ name: 'login' });
      }
    } else {
      next();
    }
  } else {
    next();
  }
});

export default router;