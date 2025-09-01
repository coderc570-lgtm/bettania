<template>
  <div
    v-if="show"
    class="fixed
    inset-0 z-50
    flex items-center
    justify-center
    bg-black bg-opacity-40"
  >
    <div
      class="bg-white
      rounded-xl 
      shadow-lg w-full
      max-w-2xl p-6
      max-h-[90vh]
      overflow-auto"
    >
      <h2 class="text-2xl font-bold mb-4">
        Add Fabric Design
      </h2>

      <form @submit.prevent="submitFabric" class="space-y-4">
        <div class="grid grid-cols-1 gap-4">
          <div>
            <label class="block text-sm font-medium mb-1">
              Fabric Design Name
            </label>
            <input
              v-model="newFabric.title"
              type="text"
              class="w-full border
              rounded-md px-3 py-2 text-sm"
              placeholder="Enter Fabric Name"
              required
            />
          </div>

          <BaseImageUpload
            folder="Fabrics"
            label="Drag & drop or click to upload Design"
            loadingMessage="Uploading Fabric Design..."
            @uploaded="newFabric.filepath = $event.path; newFabric.file = $event.file; newFabric.preview = $event.preview"
          />
        </div>

        <div class="flex justify-end gap-3 pt-4">
          <button
            type="button"
            @click="closeModal"
            class="px-4 py-2
            rounded-md bg-gray-200
            hover:bg-gray-300"
          >
            Cancel
          </button>
          <button
            type="submit"
            :disabled="loading || !newFabric.filepath"
            class="px-4 py-2
            rounded-md
            bg-deep-plum
            text-white
            hover:bg-gray-800
            disabled:opacity-50"
          >
            {{ loading ? "Adding Fabric..." : "Add Fabric Design" }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import BaseImageUpload from "@/components/Base/BaseImageUpload.vue";

export default {
  name: "AddFabricModal",
  components: { BaseImageUpload },
  props: {
    show: {
      type: Boolean,
      required: true,
    },
  },
  data() {
    return {
      newFabric: {
        title: "",
        filepath: "",
        file: null,
        preview: ""
      },
      loading: false,
    };
  },
  methods: {
    handleDrop(event) {
      const file = event.dataTransfer.files[0];
      if (file && file.type.startsWith("image/")) {
        this.uploadFile(file);
      }
    },

    handleFileSelect(event) {
      const file = event.target.files[0];
      if (file && file.type.startsWith("image/")) {
        this.uploadFile(file);
      }
    },

    async uploadFile(file) {
      this.loading = true;
      try {
        const formData = new FormData();
        formData.append("file", file);
        formData.append("folder_name", "Fabrics");

        const res = await this.$axios.post("/v1/uploads/file", formData, {
          headers: { "Content-Type": "multipart/form-data" },
        });

        this.newFabric.filepath = res.data.body.file_path;
        this.newFabric.preview = process.env.VUE_APP_FILE_PATH + res.data.body.file_path;
        this.newFabric.file = file;
      } catch (error) {
        console.error("Upload failed:", error);
        this.$notify({
          type: "error",
          title: "Upload Error",
          text: "Failed to upload image.",
        });
      } finally {
        this.loading = false;
      }
    },

    async submitFabric() {
      try {
        const formData = new FormData();
        formData.append("title", this.newFabric.title);
        formData.append("filepath", this.newFabric.filepath);

        await this.$axios.post("/v1/fabric-designs/store", formData);

        this.$notify({
          type: "success",
          title: "Success",
          text: "Fabric added successfully!",
        });
        this.$emit("saved");
        this.resetForm();
        this.closeModal();
      } catch (error) {
        console.error("Error adding Fabric:", error);
        this.$notify({
          type: "error",
          title: "Error",
          text: "Failed to add Fabric.",
        });
      }
    },

    resetForm() {
      this.newFabric = { title: "", filepath: "", file: null, preview: "" };
      this.loading = false;
    },

    closeModal() {
      this.$emit("update:show", false);
      this.resetForm();
    },
  },
};
</script>