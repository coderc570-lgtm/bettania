<template>
  <div class="min-h-screen flex flex-col items-center justify-center">
    <div class="flex-grow flex justify-center">
      <img class="" src="@/assets/images/audience.jpg" alt="Audience Image">
    </div>
    <div class="mt-11">
      <h1 class="text-4xl font-bold text-center text-gray-900">Highlighted Events</h1>
      <div class="grid grid-cols-4 gap-4 mt-8">
        <div class="flex items-center justify-center bg-gray-200 h-80 w-72">1</div>
        <div class="flex items-center justify-center bg-gray-200 h-80 w-72">2</div>
        <div class="flex items-center justify-center bg-gray-200 h-80 w-72">3</div>
        <div class="flex items-center justify-center bg-gray-200 h-80 w-72">4</div>
      </div>
    </div>

    <div class="mt-11">
      <h1 class="text-4xl font-bold text-center text-gray-900">Upcomming Events</h1>
      <div class="grid grid-cols-4 gap-4 mt-8">
        <div class="flex items-center justify-center bg-gray-200 h-80 w-72">1</div>
        <div class="flex items-center justify-center bg-gray-200 h-80 w-72">2</div>
        <div class="flex items-center justify-center bg-gray-200 h-80 w-72">3</div>
        <div class="flex items-center justify-center bg-gray-200 h-80 w-72">4</div>
      </div>
    </div>

    <div class="mt-11">
      <h1 class="text-4xl font-bold text-center text-gray-900">Search by category</h1>
      <div class="grid grid-cols-4 gap-4 mt-8">
        <div class="flex items-center justify-center bg-gray-200 h-20 w-72">1</div>
        <div class="flex items-center justify-center bg-gray-200 h-20 w-72">2</div>
        <div class="flex items-center justify-center bg-gray-200 h-20 w-72">3</div>
        <div class="flex items-center justify-center bg-gray-200 h-20 w-72">4</div>
        <div class="flex items-center justify-center bg-gray-200 h-20 w-72">5</div>
        <div class="flex items-center justify-center bg-gray-200 h-20 w-72">6</div>
        <div class="flex items-center justify-center bg-gray-200 h-20 w-72">7</div>
        <div class="flex items-center justify-center bg-gray-200 h-20 w-72">8</div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'HomePage',
});
</script>
