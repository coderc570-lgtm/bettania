<template>
  <nav class="sticky bg-soft-gray w-full z-20 top-0 start-0">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
      
      <router-link
        :to="{ name: 'home' }"
        class="flex items-center space-x-3 rtl:space-x-reverse"
      >
        <img :src="logo" class="h-16" alt="Gather Logo" />
      </router-link>

      <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse gap-2 hover:text-black">
        <router-link
          v-if="!isLoggedIn"
          :to="{ name: 'login' }"
          class="flex size-10
          items-center
          justify-center
          text-white
          bg-deep-plum
          rounded-full
          hover:bg-pale-peach
          focus:outline-none
          focus:ring-4
          dark:bg-deep-plum
          dark:hover:bg-pale-peach
          dark:focus:ring-pale-peach"
          aria-label="Sign In"
          title="Sign In"
        >
          <i class="fas fa-user hover:text-black"></i>
        </router-link>
        <ProfileMenu v-else />
        <router-link
          :to="{ name: 'cart' }"
          class="flex size-10
          items-center
          justify-center
          text-white
          bg-deep-plum
          rounded-full
          hover:bg-pale-peach
          focus:outline-none
          focus:ring-4
          dark:bg-deep-plum
          dark:hover:bg-pale-peach
          dark:focus:ring-pale-peach"
          aria-label="Cart"
          title="Cart"
        >
          <i class="fas fa-shopping-cart hover:text-black"></i>
        </router-link>

        <button
          data-collapse-toggle="navbar-sticky"
          type="button"
          class="inline-flex
          items-center p-2
          size-10justify-center
          text-sm text-gray-500
          rounded-lg md:hidden
          hover:bg-gray-100
          focus:outline-none
          focus:ring-2
          focus:ring-gray-200
          dark:text-gray-400
          dark:hover:bg-gray-700
          dark:focus:ring-gray-600"
          aria-controls="navbar-sticky"
          aria-expanded="false"
        >
          <span class="sr-only">
            Open main menu
          </span>
          <svg
            class="w-5 h-5"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 17 14"
          >
            <path
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M1 1h15M1 7h15M1 13h15"
            />
          </svg>
        </button>
      </div>

      <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
        <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-soft-gray md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0">
          <li>
            <router-link
              :to="{ name: 'home' }"
              class="block py-2 px-3
              text-dark-gray
              rounded
              md:bg-transparent
              md:text-dark-gray
              md:p-0 md:dark:text-dark-gray"
              aria-current="page"
            >
              Home
            </router-link>
          </li>
          <li>
            <router-link
              :to="{ name: 'custom-suit' }"
              class="block
              py-2 px-3
              text-dark-gray
              rounded
              hover:bg-gray-100
              md:hover:bg-transparent
              md:hover:text-blue-700
              md:p-0
              md:dark:hover:text-blue-500
              dark:hover:bg-gray-700
              dark:hover:text-white
              md:dark:hover:bg-transparent
              dark:border-gray-700"
            >
              Custom Suit
            </router-link>
          </li>
          <li>
            <router-link
              :to="{ name: 'contact' }"
              class="block
              py-2 px-3
              text-dark-gray
              rounded
              hover:bg-gray-100
              md:hover:bg-transparent
              md:hover:text-blue-700
              md:p-0
              md:dark:hover:text-blue-500
              dark:hover:bg-gray-700
              dark:hover:text-white
              md:dark:hover:bg-transparent
              dark:border-gray-700"
            >
              Contact
            </router-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import { defineComponent } from 'vue';
import { useAuthStore } from '@/store/authLogin';
import ProfileMenu from '@/pages/User/profile-menu.vue';
import logo from '@/assets/images/bettania-logo.png';

export default defineComponent({
  name: 'NavBar',
  components: { ProfileMenu },
  data() {
    return {
      showMenu: false,
      logo,
    };
  },
  computed: {
    isLoggedIn() {
      const authStore = useAuthStore();
      return authStore.isLoggedIn;
    },
  },
});
</script>