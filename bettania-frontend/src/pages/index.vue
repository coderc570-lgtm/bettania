<template>
  <div class="w-full">
    <Home/>
    <Shop/>
    <CustomSuit/>
    <Gallery/>
    <About/>
    <Explore/>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import Home from '@/components/Home/Home.vue';
import Shop from '@/components/Home/Shop.vue';
import CustomSuit from '@/components/Home/CustomSuit.vue';
import Gallery from '@/components/Home/Gallery.vue';
import About from '@/components/Home/About.vue';
import Explore from '@/components/Home/Explore.vue';

export default defineComponent({
  name: 'HomePage',
  components: {
    Home,
    Shop,
    CustomSuit,
    Gallery,
    About,
    Explore,
  },
});
</script>