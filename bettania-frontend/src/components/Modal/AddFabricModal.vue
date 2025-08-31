<template>
  <div
    v-if="show"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
  >
    <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl p-6 max-h-[90vh] overflow-auto">
      <h2 class="text-2xl font-bold mb-4">Add Fabric Design</h2>

      <form @submit.prevent="submitFabric" class="space-y-4">
        <div class="grid grid-cols-1 gap-4">
          <div>
            <label class="block text-sm font-medium mb-1">Fabric Design Name</label>
            <input
              v-model="newFabric.title"
              type="text"
              class="w-full border rounded-md px-3 py-2 text-sm"
              placeholder="Enter Fabric Name"
              required
            />
          </div>

          <div
            @dragover.prevent
            @drop.prevent="handleDrop"
            class="flex items-center
            justify-center w-full
            px-4 py-6 border-2
            border-dashed rounded-md
            cursor-pointer
            hover:border-gray-400
            transition"
          >
            <input 
              type="file"
              accept="image/*"
              class="hidden"
              @change="handleFileSelect"
              ref="fileInput"
            />
            <div class="text-center" @click="$refs.fileInput.click()">
              <p class="text-sm text-gray-500">Drag & drop or click to upload</p>
            </div>
          </div>

          <div v-if="newFabric.preview" class="mt-4 flex justify-center">
            <img
              :src="newFabric.preview"
              alt="Preview"
              class="rounded-md border max-h-48"
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
            class="px-4 py-2
            rounded-md bg-black
            text-white
            hover:bg-gray-800"
          >
            Add Fabric Design
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: "AddFabricModal",
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

    uploadFile(file) {
        const formData = new FormData();
        formData.append("file", file);
        formData.append("folder_name", "Fabrics");

        this.$axios
            .post("/v1/uploads/file", formData, {
                headers: { "Content-Type": "multipart/form-data" },
            })
            .then((res) => {
                this.newFabric.filepath = res.data.body.file_path;
                this.newFabric.preview = process.env.VUE_APP_FILE_PATH + res.data.body.file_path;
                this.newFabric.file = file;
            })
            .catch((error) => {
                console.error("Upload failed:", error);
                this.$notify({
                    type: "error",
                    title: "Upload Error",
                    text: "Failed to upload image.",
                });
            });
    },

    submitFabric() {
      const formData = new FormData();
      formData.append("title", this.newFabric.title);
      formData.append("filepath", this.newFabric.filepath);

      this.$axios
        .post("/v1/fabric-designs/store", formData)
        .then(() => {
          this.$notify({
            type: "success",
            title: "Success",
            text: "Fabric added successfully!",
          });
          this.resetForm();
          this.closeModal();
        })
        .catch((error) => {
          console.error("Error adding Fabric:", error);
          this.$notify({
            type: "error",
            title: "Error",
            text: "Failed to add Fabric.",
          });
        });
    },

    resetForm() {
      this.newFabric = { title: "", filepath: "", file: null };
    },

    closeModal() {
      this.$emit("update:show", false);
      this.resetForm();
    },
  },
};
</script>
