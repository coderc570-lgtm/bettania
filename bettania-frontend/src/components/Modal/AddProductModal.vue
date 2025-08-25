<template>
  <div
    v-if="show"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
  >
    <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl p-6 max-h-[90vh] overflow-auto">
        <h2 class="text-2xl font-bold mb-4">
            Add New Variant
        </h2>

        <form @submit.prevent="submitProduct" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">
                        Variant Category
                    </label>
                    <select
                    v-model="newProduct.variants.variant"
                    class="w-full border rounded-md px-3 py-2 text-sm"
                    required
                    >
                    <option disabled value="">Select Variant Category</option>
                    <option>Fabric</option>
                    <option>Style</option>
                    <option>Lapel</option>
                    <option>Buttons</option>
                    <option>Internal Lining</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Variant Name
                    </label>
                    <input 
                        v-model="newProduct.variants.name"
                        type="text"
                        class="w-full border rounded-md px-3 py-2 text-sm"
                        placeholder="Enter variant name"
                        required
                    >
                </div>

                <!-- Inside the form, after Variant Name input -->
<div class="col-span-1 md:col-span-2">
  <label class="block text-sm font-medium mb-1">
    Upload Image
  </label>

  <!-- Drop zone -->
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
      class="max-h-auto rounded-md border"
    />
  </div>
</div>



            </div>

            <div class="flex justify-end gap-3 pt-4">
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
                    type="submit"
                    class="px-4 py-2
                    rounded-md
                    bg-black
                    text-white
                    hover:bg-gray-800"
                >
                    Add Variant
                </button>
            </div>
        </form>
    </div>
  </div>
</template>

<script>
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
        description: "",
        price: null,
        qty: 1,
        image: "",
        imagePreview: "",
        variants: {
          name: "",
          variant: "",
        },
      },
    };
  },
methods: {
  submitProduct() {
    this.$emit("add-product", { ...this.newProduct });

    this.$notify({
      type: 'success',
      title: 'Success',
      text: 'Product added successfully!',
    });

    this.resetForm();
    this.closeModal();
  },

  resetForm() {
    this.newProduct = {
      title: "",
      description: "",
      price: null,
      qty: 1,
      image: "",
      imagePreview: "",
      variants: {
        name: "",
        variant: "",
      },
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
}

};
</script>