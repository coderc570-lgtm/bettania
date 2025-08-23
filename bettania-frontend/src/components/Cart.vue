<template>
  <div
    class="min-h-auto flex flex-col items-center justify-center py-16 md:py-32"
    data-aos="fade-up"
    data-aos-duration="1000"
  >
    <h2
      class="text-2xl md:text-4xl font-medium text-gray-800 mb-6"
      data-aos="fade-up"
      data-aos-delay="200"
      data-aos-duration="800"
    >
      Your cart is empty
    </h2>

    <button
      class="bg-black
      text-white
      px-4 md:px-8
      py-3 mb-10
      hover:bg-gray-800
      transition rounded"
      @click="$router.push({ name: 'home' })"
      data-aos="zoom-in"
      data-aos-delay="400"
      data-aos-duration="600"
    >
      Continue shopping
    </button>

    <p
      class="text-xs md:text-xl text-gray-700 text-center"
      data-aos="fade-up"
      data-aos-delay="600"
      data-aos-duration="800"
    >
      Have an account?&nbsp;
      <router-link
        :to="{ name: 'login' }"
        class="underline
        text-gray-600
        hover:text-gray-900"
      >
        Log in
      </router-link>
      &nbsp;to check out faster.
    </p>
  </div>
</template>