<template>
  <section
    class="hero-section min-h-[90vh] relative flex items-center justify-center text-center"
  >
    <div class="absolute inset-0 bg-black/30 z-0"></div>

    <div class="relative z-10" data-aos="fade-up" data-aos-delay="100">
      <h2
        class="text-3xl md:text-5xl font-semibold text-white mb-4"
        data-aos="fade-up"
        data-aos-delay="200"
      >
        Where Modern Elegance Meets Bespoke Craft
      </h2>

      <p
        class="text-white text-base md:text-xl mb-6"
        data-aos="fade-up"
        data-aos-delay="300"
      >
        Tailor your own suit from fabric to lapel, down to the last stitch.
      </p>

      <button
        class="text-white
        border border-white
        px-6 py-3 text-sm
        tracking-wide
        hover:bg-white
        hover:text-black
        transition"
        data-aos="fade-up"
        data-aos-delay="400"
      >
        Design Your Own Outfit
      </button>
    </div>

  </section>
</template>

<style scoped>
.hero-section {
  @apply bg-cover bg-top;
  background-image: url('@/assets/images/main.png');
}
</style>