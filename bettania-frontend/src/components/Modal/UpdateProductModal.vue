<template>
  <div
    v-if="show"
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50"
    data-aos="zoom-in"
  >
    <div class="bg-white rounded-2xl shadow-lg w-full max-w-lg p-6 relative">
      <button
        @click="$emit('cancel')"
        class="absolute top-3 right-3 text-gray-500 hover:text-red-500 text-xl"
      >
        <i class="ri-close-line"></i>
      </button>

      <h2 class="text-2xl font-bold mb-6 text-gray-800">Update Product</h2>

      <form @submit.prevent="updateProduct">
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1">Title</label>
          <input
            v-model="form.title"
            type="text"
            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-300"
            required
          />
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1">Category</label>
          <input
            v-model="form.category.name"
            type="text"
            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-300"
            required
          />
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1">Image URL</label>
          <input
            v-model="form.image"
            type="text"
            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-300"
          />
        </div>

        <!-- Buttons -->
        <div class="flex justify-end gap-4 mt-6">
          <button
            type="button"
            @click="$emit('cancel')"
            class="px-4 py-2 rounded-lg border border-gray-400 text-gray-600 hover:bg-gray-100"
          >
            Cancel
          </button>
          <button
            type="submit"
            class="px-6 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700"
          >
            Update
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    show: Boolean,
    product: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      form: {
        title: "",
        category: { name: "" },
        image: "",
      },
    };
  },
  watch: {
    product: {
      immediate: true,
      handler(newVal) {
        if (newVal) {
          this.form = JSON.parse(JSON.stringify(newVal)); // deep copy to avoid direct binding
        }
      },
    },
  },
  methods: {
    updateProduct() {
      this.$emit("update-product", this.form);
      this.$emit("update:show", false);
    },
  },
};
</script>
