<template>
  <div
    v-if="show"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
  >
    <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl p-6 max-h-[90vh] overflow-auto">
      <h2 class="text-2xl font-bold mb-4"> yawa Add New Custom Made</h2>

      <form @submit.prevent="submitProduct" class="space-y-4">
        <div class="grid grid-cols-1 gap-4">
          <div>
            <label class="block text-sm font-medium mb-1">Custom Made Name</label>
            <input
              v-model="newProduct.title"
              type="text"
              class="w-full border rounded-md px-3 py-2 text-sm"
              placeholder="Enter Custom Made Name"
              required
            />
          </div>
        </div>

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
            class="px-4 py-2 rounded-md bg-black text-white hover:bg-gray-800"
          >
            Add Custom Made
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "AddProductModal",
  props: {
    show: {
      type: Boolean,
      required: true,
    },
  },
  data() {
    return {
      newProduct: {
        title: "",
      },
    };
  },
  methods: {
    submitProduct() {
      const formData = new FormData();
      formData.append("title", this.newProduct.title);

      this.$axios
        .post("/v1/custom-mades/store", formData)
        .then(() => {
          this.$notify({
            type: "success",
            title: "Success",
            text: "Custom Made added successfully!",
          });
          this.resetForm();
          this.closeModal();
        })
        .catch((error) => {
          console.error("Error adding Custom Made:", error);
          this.$notify({
            type: "error",
            title: "Error",
            text: "Failed to add Custom Made.",
          });
        });
    },

    resetForm() {
      this.newProduct = { title: "" };
    },

    closeModal() {
      this.$emit("update:show", false);
      this.resetForm();
    },
  },
};
</script>
