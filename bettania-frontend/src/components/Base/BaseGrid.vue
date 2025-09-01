<template>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    <div
      v-for="(item, index) in items"
      :key="item.id || index"
      class="border rounded-xl
      shadow-sm p-4
      hover:shadow-md
      transition flex
      flex-col justify-between"
      data-aos="fade-up"
      :data-aos-delay="index * 100"
    >
      <div class="overflow-hidden rounded-lg mb-4">
        <img
          :src="filePath(item.image)"
          alt="Item Image"
          class="w-full h-48
          object-cover transform
          transition-transform
          duration-300 hover:scale-105"
        />
      </div>

      <h2 class="text-lg font-semibold text-gray-800 mb-2">
        {{ item.title }}
      </h2>

      <p class="text-sm text-gray-500 mb-4">
        {{ item.subtitle }}
      </p>

      <div class="flex justify-end gap-4 text-xl text-gray-500 mt-auto">
        <button @click="$emit('edit', item)">
          <i class="ri-edit-2-line hover:text-deep-plum"></i>
        </button>
        <button @click="$emit('delete', item)">
          <i class="ri-delete-bin-line hover:text-red-500"></i>
        </button>
      </div>
    </div>

    <div
      v-if="items.length === 0"
      class="col-span-full text-center text-gray-500 py-8"
      data-aos="fade-up"
    >
      <p>No {{ label }} found</p>
    </div>
  </div>
</template>

<script>
export default {
  name: "BaseGrid",
  props: {
    items: {
        type: Array, default: () => []
    },
    label: {
        type: String,
        default: "Items"
    },
  },
  methods: {
    filePath(path) {
      return `${process.env.VUE_APP_FILE_PATH}${path}`;
    },
  },
};
</script>