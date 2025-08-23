<template>
    <section
      class="banner-section h-[70vh] relative flex items-center justify-center text-center"
    >
      <div class="absolute inset-0 bg-black/30 z-0"></div>

      <div class="relative z-10 max-w-2xl px-4">
        <h2 class="text-3xl md:text-4xl font-semibold text-white mb-4">
          Crafted with Precision. Tailored for You.
        </h2>
        <p class="text-white text-base md:text-lg mb-6">
          From hand-selected fabrics to hand-stitched details, our suits are built with
          craftsmanship at their core. Choose your fabric, buttons, lining, and lapel – we’ll take care of the rest.
        </p>
        <button
          class="text-white border
          border-white px-6 py-3 text-sm
          tracking-wide hover:bg-white
          hover:text-black transition"
        >
          Explore Options
        </button>
      </div>
    </section>
</template>

<style scoped>
.banner-section {
  @apply bg-cover bg-center;
  background-image: url('@/assets/images/banner-2.png');
}
</style>