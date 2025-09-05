import { createWebHistory, createRouter } from 'vue-router'
import { useAuthStore } from '@/store/authLogin'

// Public pages
import UserLogin from '@/pages/login.vue'
import HomePage from '@/pages/index.vue'
import SignUp from '@/pages/register.vue'
import ProfileSettings from '@/pages/User/profile-setting.vue'
import Contact from '@/pages/contact.vue'
import CustomSuit from '@/components/CustomSuit.vue'
import CustomSuitTest from '@/components/CustomSuitTest.vue'

import Cart from '@/pages/cart.vue'

// Admin pages
import Admin from '@/pages/Admin/index.vue'
import Product from '@/pages/Admin/product.vue'
import Categories from '@/pages/Admin/categories.vue'
import User from '@/pages/Admin/user.vue'
import NewCustomSuit from '@/components/NewCustomSuit.vue'
import Fabric from '@/pages/Admin/fabric.vue'
import CustomMade from '@/pages/Admin/custom-made.vue'
import Lapel from '@/pages/Admin/lapel.vue'
import Button from '@/pages/Admin/button.vue'
import Trouser from '@/pages/Admin/trouser.vue'
import InternalLining from '@/pages/Admin/internal-lining.vue'
import Pocket from '@/pages/Admin/pocket.vue'

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
    meta: {
      title: 'Bettania - Login'
    }
  },
  {
    path: '/register',
    component: SignUp,
    name: 'register',
    meta: {
      title: 'Bettania - Register'
    }
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
    meta: {
      title: 'Bettania - Contact'
    }
  },
  {
    path: '/custom-suit',
    component: NewCustomSuit,
    name: 'custom-suit',
    meta: {
      title: 'Bettania - Custom Suit'
    }
  },
  {
    path: '/cart',
    component: Cart,
    name: 'cart',
    meta: {
      title: 'Bettania - Cart'
    }
  },

  // Admin parent with children routes
  {
    path: '/admin',
    component: Admin,
    name: 'admin',
    meta: {
      title: 'Bettania - Admin'
    }
  },
  {
    path: '/admin/product',
    component: Product,
    name: 'product',
    meta: {
      title: 'Bettania - Products'
    }
  },
  {
    path: '/admin/categories',
    component: Categories,
    name: 'categories',
    meta: {
      title: 'Bettania - Categories'
    }
  },
  {
    path: '/admin/users',
    component: User,
    name: 'user',
    meta: {
      title: 'Bettania - Users'
    }
  },

  // FABRICS
  {
    path: '/admin/fabric',
    component: Fabric,
    name: 'fabric',
    meta: {
      title: 'Bettania - Fabrics'
    }
  },
  {
    path: '/admin/custom-made',
    component: CustomMade,
    name: 'custom-made',
    meta: {
      title: 'Bettania - Custom Made'
    }
  },
  {
    path: '/admin/lapel',
    component: Lapel,
    name: 'lapel',
    meta: {
      title: 'Bettania - Lapels'
    }
  },
  {
    path: '/admin/button',
    component: Button,
    name: 'button',
    meta: {
      title: 'Bettania - Buttons'
    }
  },
  {
    path: '/admin/trouser',
    component: Trouser,
    name: 'trouser',
    meta: {
      title: 'Bettania - Trousers'
    }
  },
  {
    path: '/admin/internal-lining',
    component: InternalLining,
    name: 'internal-lining',
    meta: {
      title: 'Bettania - InternalLinings'
    }
  },
  {
    path: '/admin/pocket',
    component: Pocket,
    name: 'pocket',
    meta: {
      title: 'Bettania - Pockets'
    }
  },
  {
    path: '/test',
    component: CustomSuitTest,
    name: 'test',
    meta: {
      title: 'Bettania - Test'
    }
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