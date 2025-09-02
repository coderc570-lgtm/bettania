<template>
  <div
    v-if="show"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
  >
    <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl p-6 max-h-[90vh] overflow-auto" data-aos="zoom-in">
      <h2 class="text-2xl font-bold mb-4">
        Edit Season
      </h2>

      <form @submit.prevent="updateSeason" class="space-y-4">
        <BaseInput
          label="Season Name"
          placeholder="Enter Season Name"
          v-model="form.title"
          required
        />

        <div>
          <label class="block text-sm font-medium mb-2">
            Season Image
          </label>

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
              <p class="text-sm text-gray-500">
                Drag & drop or click to upload season
              </p>
            </div>
          </div>

          <Loading v-if="loading" class="mt-4" message="Uploading image..." />

          <div v-if="previewImage && !loading" class="mt-4 flex justify-center">
            <img
              :src="previewImage"
              alt="Preview"
              class="rounded-md border max-h-48"
            />
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
            rounded-md bg-black
            text-white
            hover:bg-gray-800
            disabled:opacity-50"
            :disabled="loading"
          >
            {{ loading ? "Updating..." : "Update Season" }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Loading from "@/components/Loading.vue";
import BaseInput from '@/components/Base/BaseInput.vue'

export default {
  components: {
    Loading,
    BaseInput
  },
  props: {
    show: Boolean,
    season: Object
  },
  data() {
    return {
      form: {
        title: "",
        filepath: "",
        file: null
      },
      previewImage: "",
      loading: false,
    };
  },
  watch: {
    season: {
      immediate: true,
      handler(f) {
        if (!f) return;
        this.form.title = f.title || "";
        this.form.filepath = f.image || "";
        this.previewImage = process.env.VUE_APP_FILE_PATH + f.image;
        this.form.file = null;
      },
    },
  },
  methods: {
    handleFileSelect(e) {
      const file = e.target.files[0];
      if (file) this.uploadImage(file);
    },
    handleDrop(e) {
      const file = e.dataTransfer.files[0];
      if (file) this.uploadImage(file);
    },
    async uploadImage(file) {
      this.loading = true;
      try {
        const formData = new FormData();
        formData.append("file", file);
        formData.append("folder_name", "Seasons");
        const res = await this.$axios.post("/v1/uploads/file", formData, {
          headers: { "Content-Type": "multipart/form-data" },
        });
        this.form.filepath = res.data.body.file_path;
        this.previewImage = process.env.VUE_APP_FILE_PATH + res.data.body.file_path;
        this.form.file = null;
      } catch (err) {
        console.error("Upload failed:", err);
        this.$notify({
          type: "error",
          title: "Upload Error",
          text: "Failed to upload image."
        });
      } finally {
        this.loading = false;
      }
    },
    async updateSeason() {
      if (!this.form.title || !this.form.filepath) {
        return this.$notify({
          type: "error",
          title: "Error",
          text: "Title and image are required."
        });
      }
      try {
        this.loading = true;
        await this.$axios.put(`/v1/fabric-seasons/${this.season.id}`, {
          title: this.form.title,
          filepath: this.form.filepath,
        });
        this.$notify({
          type: "success",
          title: "Updated",
          text: "Season updated successfully!"
        });
        this.$emit("saved");
        this.closeModal();
      } catch (err) {
        console.error(err);
        this.$notify({
          type: "error",
          title: "Error",
          text: "Failed to update season."
        });
      } finally {
        this.loading = false;
      }
    },
    closeModal() {
      this.$emit("update:show", false);
    },
  },
};
</script>