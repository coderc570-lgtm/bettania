<template>
  <div
    v-if="show"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
  >
    <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl p-6 max-h-[90vh] overflow-auto">
      <h2 class="text-2xl font-bold mb-4">Add New Variant</h2>

      <form @submit.prevent="submitProduct" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium mb-1">Variant Category</label>
            <select
              v-model="newProduct.variant_category_id"
              class="w-full border rounded-md px-3 py-2 text-sm"
              required
            >
              <option disabled value="">Select Variant Category</option>
              <option value="1">Fabric</option>
              <option value="2">Style</option>
              <option value="3">Lapel</option>
              <option value="5">Buttons</option>
              <option value="6">Internal Lining</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">Variant Name</label>
            <input
              v-model="newProduct.title"
              type="text"
              class="w-full border rounded-md px-3 py-2 text-sm"
              placeholder="Enter variant name"
              required
            />
          </div>

          <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-medium mb-1">Upload Image</label>

            <div
              @dragover.prevent
              @drop.prevent="handleDrop"
              class="flex items-center justify-center w-full px-4 py-6 border-2 border-dashed rounded-md cursor-pointer hover:border-gray-400 transition"
              @click="$refs.imageInput.click()"
            >
              <input
                type="file"
                accept="image/*"
                class="hidden"
                ref="imageInput"
                @change="handleFileUpload"
              />
              <div class="text-center">
                <p class="text-sm text-gray-500">
                  Drag & drop or <span class="text-blue-600 underline">click to upload</span>
                </p>
              </div>
            </div>

            <!-- Image Preview -->
            <div v-if="newProduct.imagePreview" class="mt-4 flex justify-center">
              <img
                :src="newProduct.imagePreview"
                alt="Preview"
                class="max-h-auto rounded-md border max-h-48"
              />
            </div>
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
            Add Variant
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

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
        variant_category_id: "",
        image: null,
        imagePreview: "",
      },
    };
  },
  methods: {
    submitProduct() {
      const formData = new FormData();
      formData.append("title", this.newProduct.title);
      formData.append("variant_category_id", this.newProduct.variant_category_id);
      if (this.newProduct.image) {
        formData.append("image", this.newProduct.image);
      }

      axios
        .post("/api/v1/variant", formData)
        .then(() => {
          this.$notify({
            type: "success",
            title: "Success",
            text: "Variant added successfully!",
          });
          this.resetForm();
          this.closeModal();
        })
        .catch((error) => {
          console.error("Error adding variant:", error);
          this.$notify({
            type: "error",
            title: "Error",
            text: "Failed to add variant.",
          });
        });
    },

    resetForm() {
      this.newProduct = {
        title: "",
        variant_category_id: "",
        image: null,
        imagePreview: "",
      };
    },

    closeModal() {
      this.$emit("update:show", false);
      this.resetForm();
    },

    handleFileUpload(event) {
      const file = event.target.files[0];
      if (file && file.type.startsWith("image/")) {
        this.newProduct.image = file;
        this.newProduct.imagePreview = URL.createObjectURL(file);
      }
    },

    handleDrop(event) {
      const file = event.dataTransfer.files[0];
      if (file && file.type.startsWith("image/")) {
        this.newProduct.image = file;
        this.newProduct.imagePreview = URL.createObjectURL(file);
      }
    },
  },
};
</script>
