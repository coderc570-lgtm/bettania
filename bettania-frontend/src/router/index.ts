 /*It won't change the URL in the browser's address bar. It maintains navigation state internally within the application*/
// import { createMemoryHistory, createRouter } from 'vue-router'
// import UserLogin from '../components/UserLogin.vue';
// import HomePage from '../components/HomePage.vue';
// import SignUp from '../components/SignUp.vue';

// const routes = [
//   { path: '/', component: HomePage, name: 'home' },
//   { path: '/login', component: UserLogin, name: 'login', },
//   { path: '/register', component: SignUp, name: 'register', },
// ]

// const router = createRouter({
//   history: createMemoryHistory(),
//   routes,
// })

// export default router;

 /*This code allows you to reflect the current route and directly access the routes*/
import { createMemoryHistory, createRouter  } from 'vue-router'
import { useAuthStore } from '@/store/authLogin'; // Import Pinia store
import UserLogin from '@/components/UserLogin.vue';
import HomePage from '@/components/HomePage.vue';
import SignUp from '@/components/SignUp.vue';
import ProfileSettings from '@/components/ProfileSettings.vue';
import CreateEvent from '@/components/CreateEvent.vue';

const routes = [
  { path: '/', component: HomePage, name: 'home' },
  { path: '/login', component: UserLogin, name: 'login', },
  { path: '/register', component: SignUp, name: 'register', },

  { 
    path: '/create-event',
    component: CreateEvent, 
    name: 'create-event',
    // meta: { requiresAuth: true} 
  },
  { 
    path: '/profile',
    component: ProfileSettings, 
    name: 'profile',
    meta: { requiresAuth: true} 
  },
]

const router = createRouter({
  history: createMemoryHistory(),
  routes,
});

// Global navigation guard
router.beforeEach(async (to, from, next) => {
  const authStore = useAuthStore(); // Access the auth store

  // Check if the route requires authentication
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // Check the user's authentication status
    if (!authStore.isLoggedIn) {
      try {
        // Attempt to check auth status from backend
        await authStore.checkAuth();
        if (!authStore.isLoggedIn) {
          // Redirect to login if not authenticated
          next({ name: 'login' });
        } else {
          next(); // Continue if authenticated
        }
      } catch (error) {
        // Redirect to login on error or failed auth check
        next({ name: 'login' });
      }
    } else {
      next(); // Continue if already logged in
    }
  } else {
    next(); // Continue if no auth required
  }
});

export default router;