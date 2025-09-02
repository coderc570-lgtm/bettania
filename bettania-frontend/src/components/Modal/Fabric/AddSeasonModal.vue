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
        Add Season
      </h2>

      <form @submit.prevent="submitSeason" class="space-y-4">
        <div class="grid grid-cols-1 gap-4">
          <BaseInput
            label="Season Name"
            placeholder="Enter Season Name"
            v-model="newSeason.title"
            required
          />

          <BaseImageUpload
            formLabel="Season Image"
            folder="Season"
            label="Drag & drop or click to upload season"
            loadingMessage="Uploading Season..."
            @uploaded="newSeason.filepath = $event.path; newSeason.file = $event.file; newSeason.preview = $event.preview"
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
            :disabled="loading || !newSeason.filepath"
            class="px-4 py-2
            rounded-md
            bg-deep-plum
            text-white
            hover:bg-l-deep-plum"
          >
            {{ loading ? "Adding..." : "Add Season" }}
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
      newSeason: {
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
        formData.append("folder_name", "Season");

        const res = await this.$axios.post("/v1/uploads/file", formData, {
          headers: { "Content-Type": "multipart/form-data" },
        });

        this.newSeason.filepath = res.data.body.file_path;
        this.newSeason.preview = process.env.VUE_APP_FILE_PATH + res.data.body.file_path;
        this.newSeason.file = file;
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

    async submitSeason() {
      try {
        const formData = new FormData();
        formData.append("title", this.newSeason.title);
        formData.append("filepath", this.newSeason.filepath);

        await this.$axios.post("/v1/fabric-seasons/store", formData);

        this.$notify({
          type: "success",
          title: "Success",
          text: "Season added successfully!",
        });
        this.$emit("saved");
        this.resetForm();
        this.closeModal();
      } catch (error) {
        console.error("Error adding Season:", error);
        this.$notify({
          type: "error",
          title: "Error",
          text: "Failed to add Season.",
        });
      }
    },

    resetForm() {
      this.newSeason = { title: "", filepath: "", file: null, preview: "" };
      this.loading = false;
    },

    closeModal() {
      this.$emit("update:show", false);
      this.resetForm();
    },
  },
};
</script>