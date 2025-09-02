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
      data-aos="zoom-in"
    >
      <h2 class="text-2xl font-bold mb-4">
        Add Design
      </h2>

      <form @submit.prevent="submitDesign" class="space-y-4">
        <div class="grid grid-cols-1 gap-4">
          <BaseInput
            label="Design Name"
            placeholder="Enter Design Name"
            v-model="newDesign.title"
            required
          />

          <BaseImageUpload
            formLabel="Design Image"
            folder="Design"
            label="Drag & drop or click to upload design"
            loadingMessage="Uploading Design..."
            @uploaded="newDesign.filepath = $event.path; newDesign.file = $event.file; newDesign.preview = $event.preview"
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
            :disabled="loading || !newDesign.filepath"
            class="px-4 py-2
            rounded-md
            bg-deep-plum
            text-white
            hover:bg-l-deep-plum"
          >
            {{ loading ? "Adding..." : "Add Design" }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import BaseImageUpload from "@/components/Base/BaseImageUpload.vue";
import BaseInput from '@/components/Base/BaseInput.vue'

export default {
  components: {
    BaseImageUpload,
    BaseInput
  },
  props: {
    show: {
      type: Boolean,
      required: true,
    },
  },
  data() {
    return {
      newDesign: {
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
        formData.append("folder_name", "Design");

        const res = await this.$axios.post("/v1/uploads/file", formData, {
          headers: { "Content-Type": "multipart/form-data" },
        });

        this.newDesign.filepath = res.data.body.file_path;
        this.newDesign.preview = process.env.VUE_APP_FILE_PATH + res.data.body.file_path;
        this.newDesign.file = file;
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

    async submitDesign() {
      try {
        const formData = new FormData();
        formData.append("title", this.newDesign.title);
        formData.append("filepath", this.newDesign.filepath);

        await this.$axios.post("/v1/fabric-designs/store", formData);

        this.$notify({
          type: "success",
          title: "Success",
          text: "Design added successfully!",
        });
        this.$emit("saved");
        this.resetForm();
        this.closeModal();
      } catch (error) {
        console.error("Error adding Design:", error);
        this.$notify({
          type: "error",
          title: "Error",
          text: "Failed to add Design.",
        });
      }
    },

    resetForm() {
      this.newDesign = { title: "", filepath: "", file: null, preview: "" };
      this.loading = false;
    },

    closeModal() {
      this.$emit("update:show", false);
      this.resetForm();
    },
  },
};
</script>