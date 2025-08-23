<template>
  <footer class="bg-white text-black border-t border-gray-200">

    <!-- Top section -->
    <div class="max-w-screen-xl mx-auto py-12 px-4 grid grid-cols-1 md:grid-cols-3 gap-8 items-start text-sm">
      
      <!-- Logo -->
      <div class="flex justify-center md:justify-start">
        <img :src="logo" alt="Bettania Logo" class="h-32 w-auto object-contain" />
      </div>

      <!-- Quick Links -->
      <div class="text-center">
        <h3 class="text-base font-semibold mb-4">Quick links</h3>
        <ul class="space-y-2">
          <li>
            <router-link to="/" class="hover:underline">Home</router-link>
          </li>
          <li>
            <router-link to="/custom-suit" class="hover:underline">Custom Suit</router-link>
          </li>
          <li>
            <router-link to="/contact" class="hover:underline">Contact</router-link>
          </li>
        </ul>
      </div>

      <!-- Social Icons -->
      <div class="flex justify-center md:justify-end gap-4 text-xl">
        <a href="#" aria-label="Facebook" class="hover:text-gray-600"><i class="fab fa-facebook-f"></i></a>
        <a href="#" aria-label="Instagram" class="hover:text-gray-600"><i class="fab fa-instagram"></i></a>
        <a href="#" aria-label="YouTube" class="hover:text-gray-600"><i class="fab fa-youtube"></i></a>
        <a href="#" aria-label="TikTok" class="hover:text-gray-600"><i class="fab fa-tiktok"></i></a>
        <a href="#" aria-label="Twitter" class="hover:text-gray-600"><i class="fab fa-x-twitter"></i></a>
        <a href="#" aria-label="Pinterest" class="hover:text-gray-600"><i class="fab fa-pinterest"></i></a>
      </div>
    </div>

    <!-- Bottom copyright -->
    <div class="border-t border-gray-300 text-center py-4 text-xs text-gray-500 px-4 flex flex-col md:flex-row items-center justify-between max-w-screen-xl mx-auto">
      <span>© 2025, Bettania Suits Powered by Infogoy</span>
      <router-link to="/privacy-policy" class="mt-2 md:mt-0 hover:underline">Privacy policy</router-link>
    </div>

  </footer>
</template>

<script setup lang="ts">
import logo from '@/assets/images/bettania-logo.png';
</script>
