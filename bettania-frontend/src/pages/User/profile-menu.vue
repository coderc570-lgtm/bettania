<template>
    <div class="relative">
        <button
          class="flex size-10
          items-center justify-center
          text-white bg-deep-plum
          rounded-full
          hover:bg-pale-peach
          focus:outline-none
          focus:ring-4
          dark:bg-deep-plum
          dark:hover:bg-pale-peach
          dark:focus:ring-pale-peach"
          aria-label="Sign In"
          title="Sign In"
          @click="toggleMenu"
        >
          <i class="fas fa-user hover:text-black"></i>
        </button>
        <div
          v-if="showMenu"
          class="absolute
          flex flex-col z-30
          right-0 mt-2 w-48
          bg-white border
          border-gray-200
          rounded-lg shadow-lg"
         >
            <router-link
              :to="{ name: 'profile' }"
              class="px-4 py-2
              hover:bg-gray-100
              cursor-pointer"
            >
              View profile
            </router-link>
            <div
              class="px-4 py-2
              hover:bg-gray-100
              cursor-pointer"
              @click="logout"
            >
              Sign out
            </div>
        </div>
      </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { useAuthStore } from '@/store/authLogin';

export default defineComponent({
  name: 'ProfileMenu',
  data() {
    return{
        showMenu: false,
    }
  },
  methods: {
    toggleMenu() {
      this.showMenu =!this.showMenu;
      
    },
    closeDropdown(event: Event) {
      const target = event.target as HTMLElement;
      if (this.$el && !this.$el.contains(target)) {
        this.showMenu = false;
      }
    },
    logout() {
      const authStore = useAuthStore();
      authStore.logout();
      this.$router.push({ name: 'login' });
    },
  },
  mounted() {
    document.addEventListener('click', this.closeDropdown);
  },
  beforeUnmount() {
    document.removeEventListener('click', this.closeDropdown);
  }
});
</script>