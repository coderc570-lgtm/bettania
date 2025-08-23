<template>
  <section
    class="min-h-screen bg-white flex flex-col px-16 md:px-24 py-12"
    data-aos="fade-up"
  >
    <h2 class="text-lg font-medium text-gray-800 mb-4" data-aos="fade-up" data-aos-delay="100">
      SHOP THIS OUTFIT
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 flex-grow" data-aos="fade-up" data-aos-delay="200">
      <div class="grid grid-cols-2 md:grid-cols-1 gap-4 md:h-full">
        <img
          src="@/assets/images/model-3.webp"
          alt="Outfit 1"
          class="w-full h-full object-cover rounded"
          data-aos="zoom-in"
          data-aos-delay="300"
        />
        <img
          src="@/assets/images/model-2.webp"
          alt="Outfit 2"
          class="w-full h-full object-cover rounded"
          data-aos="zoom-in"
          data-aos-delay="300"
        />
      </div>

      <div class="md:col-span-2 h-full">
        <img
          src="@/assets/images/model-1.webp"
          alt="Outfit 3"
          class="w-full h-full object-cover rounded"
          data-aos="zoom-in"
          data-aos-delay="300"
        />
      </div>
    </div>
  </section>
</template>
