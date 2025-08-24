import { createWebHistory, createRouter } from 'vue-router'
import { useAuthStore } from '@/store/authLogin'

// Public pages
import UserLogin from '@/pages/login.vue'
import HomePage from '@/pages/index.vue'
import SignUp from '@/pages/register.vue'
import ProfileSettings from '@/pages/User/profile-setting.vue'
import CreateEvent from '@/components/CreateEvent.vue'
import Contact from '@/pages/contact.vue'
import CustomSuit from '@/components/CustomSuit.vue'
import Cart from '@/pages/cart.vue'

// Admin pages
import Admin from '@/pages/Admin/index.vue'
import Product from '@/pages/Admin/product.vue'
import Categories from '@/pages/Admin/categories.vue'
import User from '@/pages/Admin/user.vue'

const routes = [
  {
    path: '/',
    component: HomePage,
    name: 'home',
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
    meta: { requiresAuth: true },
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
  {
    path: '/cart',
    component: Cart,
    name: 'cart',
  },

  // Admin parent with children routes
  {
    path: '/admin',
    component: Admin,
    name: 'admin',
  },
  {
    path: '/admin/product',
    component: Product,
    name: 'product',
  },
  {
    path: '/admin/categories',
    component: Categories,
    name: 'categories',
  },
  {
    path: '/admin/users',
    component: User,
    name: 'user',
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

// Navigation guard
router.beforeEach(async (to, from, next) => {
  const authStore = useAuthStore()

  if (to.matched.some((record) => record.meta.requiresAuth)) {
    if (!authStore.isLoggedIn) {
      try {
        await authStore.checkAuth()
        if (!authStore.isLoggedIn) {
          next({ name: 'login' })
        } else {
          next()
        }
      } catch (error) {
        next({ name: 'login' })
      }
    } else {
      next()
    }
  } else {
    next()
  }
})

export default router