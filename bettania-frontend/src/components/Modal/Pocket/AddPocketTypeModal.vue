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
        Add Pocket Type
      </h2>

      <form @submit.prevent="submitPocketType" class="space-y-4">
        <BaseInput
          label="Pocket Type Name"
          placeholder="Enter Pocket Type Name"
          v-model="newPocketType.name"
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
            :disabled="loading || !newPocketType.name"
            class="px-4 py-2 rounded-md bg-deep-plum text-white hover:bg-l-deep-plum"
          >
            {{ loading ? "Adding..." : "Add Pocket Type" }}
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
  },
  data() {
    return {
      newPocketType: {
        name: "",
      },
      loading: false,
    };
  },
  methods: {
    async submitPocketType() {
      this.loading = true;
      try {
        const payload = {
          name: this.newPocketType.name,
        };

        await this.$axios.post("/v1/pocket-types/store", payload);

        this.$notify({
          type: "success",
          title: "Success",
          text: "Pocket Type added successfully!",
        });

        this.$emit("saved");
        this.resetForm();
        this.closeModal();
      } catch (error) {
        console.error("Error adding pocket type:", error);
        this.$notify({
          type: "error",
          title: "Error",
          text: "Failed to add pocket type.",
        });
      } finally {
        this.loading = false;
      }
    },
    resetForm() {
      this.newPocketType.name = "";
      this.loading = false;
    },
    closeModal() {
      this.$emit("update:show", false);
      this.resetForm();
    },
  },
};
</script>