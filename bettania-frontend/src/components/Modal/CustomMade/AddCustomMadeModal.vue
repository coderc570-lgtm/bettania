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
        Add Custom Made
      </h2>

      <form @submit.prevent="submitCustomMade" class="space-y-4">
        <BaseInput
          label="Custom Made Name"
          placeholder="Enter Custom Made Name"
          v-model="newCustomMade.title"
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
            :disabled="loading || !newCustomMade.title"
            class="px-4 py-2 rounded-md bg-deep-plum text-white hover:bg-l-deep-plum"
          >
            {{ loading ? "Adding..." : "Add Custom Made" }}
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
      newCustomMade: {
        title: "",
      },
      loading: false,
    };
  },
  methods: {
    async submitCustomMade() {
      this.loading = true;
      try {
        const payload = {
          title: this.newCustomMade.title,
        };

        await this.$axios.post("/v1/custom-mades/store", payload);

        this.$notify({
          type: "success",
          title: "Success",
          text: "Custom made added successfully!",
        });

        this.$emit("saved");
        this.resetForm();
        this.closeModal();
      } catch (error) {
        console.error("Error adding custom made:", error);
        this.$notify({
          type: "error",
          title: "Error",
          text: "Failed to add custom made.",
        });
      } finally {
        this.loading = false;
      }
    },
    resetForm() {
      this.newCustomMade.title = "";
      this.loading = false;
    },
    closeModal() {
      this.$emit("update:show", false);
      this.resetForm();
    },
  },
};
</script>
