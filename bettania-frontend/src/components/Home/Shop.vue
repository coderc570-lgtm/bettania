<template>
    <section class="min-h-screen bg-white flex flex-col px-16 md:px-24 py-12">
      <h2 class="text-lg font-medium text-gray-800 mb-4">
        SHOP THIS OUTFIT
      </h2>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 flex-grow">
        <div class="grid grid-cols-2 md:grid-cols-1 gap-4 md:h-full">
          <img
            src="@/assets/images/model-3.webp"
            alt="Outfit 1"
            class="w-full h-full object-cover rounded"
          />
          <img
            src="@/assets/images/model-2.webp"
            alt="Outfit 2"
            class="w-full h-full object-cover rounded"
          />
        </div>

        <div class="md:col-span-2 h-full">
          <img
            src="@/assets/images/model-1.webp"
            alt="Outfit 3"
            class="w-full h-full object-cover rounded"
          />
        </div>
      </div>
    </section>
</template>