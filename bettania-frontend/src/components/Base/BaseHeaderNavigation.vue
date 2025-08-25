<template>
  <BaseHeader class="bg-gradient-to-r from-deep-plum to-l-deep-plum shadow-md">
    <div class="mx-16 mb-8 mt-20">
      <span class="flex items-center gap-6 pb-3 text-[1rem] font-medium text-white">
        <span class="h-[2px] w-10 bg-white"></span>

        <router-link
          to="/"
          class="px-3 py-1
          rounded-md
          transition-colors
          duration-200
          hover:bg-white
          hover:text-black"
        >
          HOME
        </router-link>
        <router-link
          to="/admin"
          class="px-3 py-1
          rounded-md
          transition-colors
          duration-200
          hover:bg-white
          hover:text-black"
        >
          ADMIN
        </router-link>
      </span>

      <h1 class="text-4xl font-extrabold text-white lg:text-6xl">
        {{ title }}
      </h1>
    </div>
  </BaseHeader>
</template>

<script>
export default {
  name: "BaseHeaderNavigation",
  props: {
    title: {
      type: String,
      required: true,
    },
  },
};
</script>