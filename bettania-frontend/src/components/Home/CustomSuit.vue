<template>
  <section class="h-[70vh] bg-stone-gray flex flex-col px-16 md:px-24 py-12" data-aos="fade-up">
    <div class="grid grid-cols-2">
      <div class="h-full" data-aos="zoom-in-right" data-aos-delay="400">
        <img
          src="@/assets/images/tailoring.png"
          alt="Tailoring"
          class="w-full h-full object-cover rounded"
        />
      </div>

      <div
        class="m-12 flex
        flex-col items-start
        justify-center gap-8"
        data-aos="fade-left"
        data-aos-delay="400"
      >
        <h1 class="text-2xl font-bold">
          THE SIGNATURE SUIT
        </h1>
        <p class="text-md font-bold">
          Tailored to fit. Designed for distinction.
        </p>
        <p class="font-light">
          Customize your suit from fabric to lapel, buttons
          to lining — even trousers. Your style, your rules.
        </p>
        <button
          class="px-6 py-3 border
          border-black text-black
          font-light rounded
          hover:bg-black
          hover:text-white transition"
          data-aos="fade-up"
          data-aos-delay="600"
        >
          Design your own outfit
        </button>
      </div>
    </div>
  </section>
</template>
