<template>
  <div
    v-if="show"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
  >
    <div
      class="bg-white rounded-xl shadow-lg w-full max-w-2xl p-6 max-h-[90vh] overflow-auto"
      data-aos="zoom-in"
    >
      <h2 class="text-2xl font-bold mb-4">
        Add Button
      </h2>

      <form @submit.prevent="submitButton" class="space-y-4">
        <div class="grid grid-cols-1 gap-4">
          <BaseInput
            label="Button Name"
            placeholder="Enter Button Name"
            v-model="newButton.name"
            required
          />

          <BaseInput
            label="Price"
            type="number"
            placeholder="Enter Price"
            v-model="newButton.price"
            required
          />

          <BaseImageUpload
            formLabel="Button Image"
            folder="Button"
            label="Drag & drop or click to upload button"
            loadingMessage="Uploading Button..."
            @uploaded="newButton.filepath = $event.path; newButton.file = $event.file; newButton.preview = $event.preview"
          />
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
            :disabled="loading || !newButton.filepath"
            class="px-4 py-2 rounded-md bg-deep-plum text-white hover:bg-l-deep-plum"
          >
            {{ loading ? "Adding..." : "Add Button" }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import BaseImageUpload from "@/components/Base/BaseImageUpload.vue";
import BaseInput from "@/components/Base/BaseInput.vue";

export default {
  components: {
    BaseImageUpload,
    BaseInput,
  },
  props: {
    show: {
      type: Boolean,
      required: true,
    },
  },
  data() {
    return {
      newButton: {
        name: "",
        price: "",
        filepath: "",
        file: null,
        preview: "",
      },
      loading: false,
    };
  },
  methods: {
    async submitButton() {
      this.loading = true;
      try {
        const formData = new FormData();
        formData.append("name", this.newButton.name);
        formData.append("price", this.newButton.price);
        formData.append("filepath", this.newButton.filepath);

        await this.$axios.post("/v1/buttons/store", formData);

        this.$notify({
          type: "success",
          title: "Success",
          text: "Button added successfully!",
        });
        this.$emit("saved");
        this.resetForm();
        this.closeModal();
      } catch (error) {
        console.error("Error adding Button:", error);
        this.$notify({
          type: "error",
          title: "Error",
          text: "Failed to add Button.",
        });
      } finally {
        this.loading = false;
      }
    },

    resetForm() {
      this.newButton = {
        name: "",
        price: "",
        filepath: "",
        file: null,
        preview: "",
      };
      this.loading = false;
    },

    closeModal() {
      this.$emit("update:show", false);
      this.resetForm();
    },
  },
};
</script>
