
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
        Delete Material
      </h2>
      <p class="text-gray-700 mb-6">
        Are you sure you want to delete
        <span class="font-semibold">
          {{ material.fabric_materials_title }}
        </span>?
      </p>

      <div class="flex justify-end gap-3">
        <button
          type="button"
          @click="$emit('update:show', false)"
          class="px-4 py-2
          rounded-md
          bg-gray-200
          hover:bg-gray-300"
        >
          Cancel
        </button>

        <button
          type="button"
          @click="deleteMill"
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
    material: {
      type: Object, default: () => ({})
    },
  },
  data() {
    return {
      loading: false,
    };
  },
  methods: {
    async deleteMill() {
      if (!this.material?.fabric_materials_id) return;

      this.loading = true;
      try {
        await this.$axios.delete(`/v1/fabric-materials/delete/${this.material.fabric_materials_id}`);

        this.$notify({
          type: "success",
          title: "Deleted",
          text: "Marerial deleted successfully.",
        });

        this.$emit("deleted");
        this.$emit("update:show", false);
      } catch (err) {
        console.error("Delete failed:", err);
        this.$notify({
          type: "error",
          title: "Error",
          text: "Failed to delete Marerial.",
        });
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>