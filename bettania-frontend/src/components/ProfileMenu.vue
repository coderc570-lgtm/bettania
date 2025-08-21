<template>
    <div class="relative">
        <img 
         src="https://imgur.com/O9Wmyek.png"
         alt="Profile Picture"
         class="w-12 h-12 rounded-full cursor-pointer"
         @click="toggleMenu"
        />
        <div
         v-if="showMenu"
         class="absolute flex flex-col z-30 right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg"
         >
            <router-link
             :to="{ name: 'profile' }"
             class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
             >
             View profile
            </router-link>
            <router-link
             :to="{ name: 'home' }"
             class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
             >
             Manage organizer
            </router-link>
            <router-link
             :to="{ name: 'home' }"
             class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
             >
             Manage event
            </router-link>
            <router-link
             :to="{ name: 'home' }"
             class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
             >
             My save events
            </router-link>
            <router-link
             :to="{ name: 'home' }"
             class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
             >
             Following organizer
            </router-link>
            <div
             class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
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
    // Close the dropdown menu when clicked outside of it
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
  //Listener for the close Dropdown
  mounted() {
    document.addEventListener('click', this.closeDropdown);
  },
  beforeUnmount() {
    document.removeEventListener('click', this.closeDropdown);
  }
});
</script>