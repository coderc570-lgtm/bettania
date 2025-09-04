<template>
  <div
    v-if="show"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
  >
    <div
      class="bg-white rounded-xl shadow-lg w-full max-w-md p-6"
      data-aos="zoom-in"
    >
      <h2 class="text-xl font-bold mb-4 text-red-600">Delete Button</h2>
      <p class="mb-6 text-gray-700">
        Are you sure you want to delete
        <span class="font-semibold">{{ button?.buttons_name }}</span>?
      </p>

      <div class="flex justify-end gap-3">
        <button
          type="button"
          @click="closeModal"
          class="px-4 py-2 rounded-md bg-gray-200 hover:bg-gray-300"
        >
          Cancel
        </button>
        <button
          type="button"
          :disabled="loading"
          @click="confirmDelete"
          class="px-4 py-2 rounded-md bg-red-600 text-white hover:bg-red-700"
        >
          {{ loading ? "Deleting..." : "Delete" }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    show: { type: Boolean, required: true },
    button: { type: Object, default: null },
  },
  data() {
    return {
      loading: false,
    };
  },
  methods: {
    async confirmDelete() {
      if (!this.button) return;

      try {
        this.loading = true;
        await this.$axios.delete(`/v1/buttons/delete/${this.button.buttons_id}`);

        this.$notify({
          type: "success",
          title: "Deleted",
          text: "Button deleted successfully.",
        });

        this.$emit("deleted");
        this.closeModal();
      } catch (error) {
        this.$notify({
          type: "error",
          title: "Error",
          text: error.response?.data?.message || "Failed to delete Button.",
        });
      } finally {
        this.loading = false;
      }
    },
    closeModal() {
      this.$emit("update:show", false);
    },
  },
};
</script>
