<template>
  <div
    v-if="show"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
  >
    <div
      class="bg-white rounded-xl shadow-lg w-full max-w-md p-6"
      data-aos="zoom-in"
    >
      <h2 class="text-2xl font-bold mb-4">
        Edit Pocket Type
      </h2>

      <form @submit.prevent="updatePocketType" class="space-y-4">
        <BaseInput
          label="Pocket Type Name"
          placeholder="Enter Pocket Type Name"
          v-model="editPocketType.pocket_types_name"
          required
        />

        <div class="flex justify-end gap-3 pt-4">
          <button
            type="button"
            @click="closeModal"
            class="px-4 py-2 rounded-md bg-gray-200 hover:bg-gray-300"
          >
            Cancel
          </button>
          <button
            type="submit"
            :disabled="loading || !editPocketType.pocket_types_name"
            class="px-4 py-2 rounded-md bg-deep-plum text-white hover:bg-l-deep-plum"
          >
            {{ loading ? "Saving..." : "Save Changes" }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import BaseInput from "@/components/Base/BaseInput.vue";

export default {
  components: { BaseInput },
  props: {
    show: {
      type: Boolean,
      required: true,
    },
    pocketType: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      editPocketType: {
        id: null,
        name: "",
      },
      loading: false,
    };
  },
  watch: {
    pocketType: {
      immediate: true,
      handler(newVal) {
        if (newVal) {
          this.editPocketType = { ...newVal };
        }
      },
    },
  },
  methods: {
    async updatePocketType() {
      this.loading = true;
      try {
        const payload = {
          name: this.editPocketType.pocket_types_name,
        };

        await this.$axios.put(`/v1/pocket-types/${this.editPocketType.pocket_types_id}`, payload);

        this.$notify({
          type: "success",
          title: "Success",
          text: "Pocket Type updated successfully!",
        });

        this.$emit("saved");
        this.closeModal();
      } catch (error) {
        console.error("Error updating pocket type:", error);
        this.$notify({
          type: "error",
          title: "Error",
          text: "Failed to update pocket type.",
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
