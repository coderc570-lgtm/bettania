<template>
  <div>
    <label class="block text-sm font-medium mb-2">
      {{ formLabel }}
    </label>
    <div
      @dragover.prevent
      @drop.prevent="handleDrop"
      class="flex items-center
      justify-center w-full
      px-4 py-6 border-2
      border-dashed
      rounded-md
      cursor-pointer
      hover:border-gray-400
      transition"
      @click="$refs.fileInput.click()"
    >
      <input
        type="file"
        accept="image/*"
        class="hidden"
        @change="handleFileSelect"
        ref="fileInput"
      />
      <div class="text-center">
        <p class="text-sm text-gray-500">{{ label }}</p>
      </div>
    </div>

    <Loading
        v-if="loading"
        :message="loadingMessage"
    />

    <div
        v-if="preview && !loading"
        class="mt-4 flex justify-center"
    >
      <img
        :src="preview"
        :alt="alt"
        class="rounded-md
        border max-h-48"
      />
    </div>
  </div>
</template>

<script>
import Loading from "@/components/Loading.vue";

export default {
  name: "BaseImageUpload",
  components: { Loading },
  props: {
    label: {
      type: String,
      default: "Drag & drop or click to upload"
    },
    alt: {
      type: String,
      default: "Preview"
    },
    loadingMessage: {
      type: String,
      default: "Uploading..."
    },
    folder: {
      type: String,
      default: "uploads"
    },
    formLabel: {
      type: String,
      default: "Image"
    }
  },
  data() {
    return {
      file: null,
      preview: null,
      loading: false
    };
  },
  methods: {
    handleDrop(event) {
      const file = event.dataTransfer.files[0];
      this.uploadFile(file);
    },
    handleFileSelect(event) {
      const file = event.target.files[0];
      this.uploadFile(file);
    },
    async uploadFile(file) {
      if (!file || !file.type.startsWith("image/")) return;

      this.file = file;
      this.preview = URL.createObjectURL(file);
      this.loading = true;

      try {
        const formData = new FormData();
        formData.append("file", file);
        formData.append("folder_name", this.folder);

        const res = await this.$axios.post("/v1/uploads/file", formData, {
          headers: { "Content-Type": "multipart/form-data" },
        });

        const uploadedPath = res.data.body.file_path;
        this.preview = process.env.VUE_APP_FILE_PATH + uploadedPath;

        this.$emit("uploaded", { file, path: uploadedPath, preview: this.preview });
      } catch (err) {
        console.error("Upload failed:", err);
        this.$notify({
          type: "error",
          title: "Upload Error",
          text: "Failed to upload image.",
        });
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>