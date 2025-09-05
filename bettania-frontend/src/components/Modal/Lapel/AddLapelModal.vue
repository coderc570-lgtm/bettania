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
        Add Lapel
      </h2>

      <form @submit.prevent="submitLapel" class="space-y-4">
        <div class="grid grid-cols-1 gap-4">
          <BaseInput
            label="Lapel Name"
            placeholder="Enter Lapel Name"
            v-model="newLapel.name"
            required
          />

          <BaseInput
            label="Price"
            type="number"
            placeholder="Enter Price"
            v-model="newLapel.price"
            required
          />

          <BaseInput
            label="Description"
            type="text"
            placeholder="Enter Description"
            v-model="newLapel.description"
            required
          />

          <BaseImageUpload
            formLabel="Lapel Image"
            folder="Lapel"
            label="Drag & drop or click to upload lapel"
            loadingMessage="Uploading Lapel..."
            @uploaded="newLapel.filepath = $event.path; newLapel.file = $event.file; newLapel.preview = $event.preview"
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
            :disabled="loading || !newLapel.filepath"
            class="px-4 py-2 rounded-md bg-deep-plum text-white hover:bg-l-deep-plum"
          >
            {{ loading ? "Adding..." : "Add Lapel" }}
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
      newLapel: {
        name: "",
        price: "",
        description: "",
        filepath: "",
        file: null,
        preview: "",
      },
      loading: false,
    };
  },
  methods: {
    async submitLapel() {
      this.loading = true;
      try {
        const formData = new FormData();
        formData.append("name", this.newLapel.name);
        formData.append("price", this.newLapel.price);
        formData.append("description", this.newLapel.description);
        formData.append("filepath", this.newLapel.filepath);

        await this.$axios.post("/v1/lapels/store", formData);

        this.$notify({
          type: "success",
          title: "Success",
          text: "Lapel added successfully!",
        });
        this.$emit("saved");
        this.resetForm();
        this.closeModal();
      } catch (error) {
        console.error("Error adding Lapel:", error);
        this.$notify({
          type: "error",
          title: "Error",
          text: "Failed to add Lapel.",
        });
      } finally {
        this.loading = false;
      }
    },

    resetForm() {
      this.newLapel = {
        name: "",
        price: "",
        description: "",
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
