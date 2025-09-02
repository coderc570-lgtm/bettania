<template>
  <div
    v-if="show"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
  >
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6" data-aos="zoom-in">
      <h2 class="text-xl font-bold mb-4">Delete Product</h2>
      <p class="text-gray-700 mb-6">
        Are you sure you want to delete
        <strong>{{ product?.title }}</strong>?
      </p>
      <div class="flex justify-end gap-3">
        <button
          @click="$emit('cancel')"
          class="px-4 py-2 rounded-md bg-gray-200 hover:bg-gray-300"
        >
          Cancel
        </button>
        <button
          @click="$emit('confirm')"
          class="px-4 py-2 rounded-md bg-red-600 text-white hover:bg-red-700"
        >
          Delete
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "DeleteProductModal",
  props: {
    show: {
      type: Boolean,
      required: true,
    },
    product: {
      type: Object,
      required: false,
    },
  },
};
</script>