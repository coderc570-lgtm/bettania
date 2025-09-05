<template>
  <div
    v-if="show"
    class="fixed inset-0
    z-50 flex items-center
    justify-center
    bg-black
    bg-opacity-40"
  >
    <div class="bg-white rounded-xl shadow-lg w-full max-w-sm p-6" data-aos="zoom-in">
      <h2 class="text-xl font-bold mb-4 text-red-600">
        Delete Custom Made
      </h2>
      <p class="text-gray-700 mb-6">
        Are you sure you want to delete
        <span class="font-semibold">
          {{ custom.custom_mades_title }}
        </span>?
      </p>

      <div class="flex justify-end gap-3">
        <button
          type="button"
          @click="closeModal"
          class="px-4 py-2
          rounded-md
          bg-gray-200
          hover:bg-gray-300"
        >
          Cancel
        </button>

        <button
          type="button"
          @click="confirmDelete"
          class="px-4 py-2
          rounded-md
          bg-red-600
          text-white
          hover:bg-red-700"
          :disabled="loading"
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
    show: {
      type: Boolean,
      required: true
    },
    custom: {
      type: Object,
      default: () => ({})
    },
  },
  data() {
    return {
      loading: false,
    };
  },
  methods: {
    closeModal() {
      this.$emit("update:show", false);
    },
    async confirmDelete() {
      try {
        this.loading = true;
        await this.$axios.delete(
          `/v1/custom-mades/delete/${this.custom.custom_mades_id}`
        );
        this.$notify({
          type: "success",
          title: "Deleted",
          text: "Custom made deleted successfully!",
        });
        this.$emit("deleted");
        this.closeModal();
      } catch (err) {
        console.error("Delete error:", err);
        this.$notify({
          type: "error",
          title: "Error",
          text: "Failed to delete custom made.",
        });
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>