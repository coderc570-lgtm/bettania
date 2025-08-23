<template>
  <div id="app">
    <NavBar />
    <router-view />
    <notifications />
    <Footer/>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import NavBar from '@/components/NavBar.vue';
import Footer from '@/components/Footer.vue';

export default defineComponent({
  name: 'App',
  components: {
    NavBar,
    Footer
  },
});
</script>
