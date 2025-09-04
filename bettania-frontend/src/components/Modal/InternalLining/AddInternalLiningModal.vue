<template>
  <div
    v-if="show"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
  >
    <div
      class="bg-white rounded-xl shadow-lg w-full max-w-2xl p-6 max-h-[90vh] overflow-auto"
      data-aos="zoom-in"
    >
      <h2 class="text-2xl font-bold mb-4">Add Internal Lining</h2>

      <form @submit.prevent="submitInternalLining" class="space-y-4">
        <div class="grid grid-cols-1 gap-4">
          <BaseInput
            label="Internal Lining Name"
            placeholder="Enter Internal Lining Name"
            v-model="newInternalLining.name"
            required
          />

          <BaseInput
            label="Price"
            type="number"
            placeholder="Enter Price"
            v-model="newInternalLining.price"
            required
          />

          <BaseImageUpload
            formLabel="Main Internal Lining Image"
            folder="Internal Lining"
            label="Drag & drop or click to upload main image"
            loadingMessage="Uploading image..."
            @uploaded="newInternalLining.filepath = $event.path"
          />

          <BaseImageUpload
            formLabel="Upper Lining Image"
            folder="Internal Lining"
            label="Upload Upper Filepath"
            loadingMessage="Uploading upper image..."
            @uploaded="newInternalLining.upper_filepath = $event.path"
          />

          <BaseImageUpload
            formLabel="Lower Lining Image"
            folder="Internal Lining"
            label="Upload Lower Filepath"
            loadingMessage="Uploading lower image..."
            @uploaded="newInternalLining.lower_filepath = $event.path"
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
            :disabled="loading"
            class="px-4 py-2 rounded-md bg-deep-plum text-white hover:bg-l-deep-plum"
          >
            {{ loading ? "Adding..." : "Add Internal Lining" }}
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
      newInternalLining: {
        name: "",
        price: "",
        filepath: "",
        upper_filepath: "",
        lower_filepath: "",
      },
      loading: false,
    };
  },
  methods: {
    async submitInternalLining() {
      if (!this.newInternalLining.name || !this.newInternalLining.price) {
        return this.$notify({
          type: "error",
          title: "Error",
          text: "Name and price are required.",
        });
      }

      this.loading = true;

      try {
        const payload = {
          name: this.newInternalLining.name,
          price: this.newInternalLining.price,
          filepath: this.newInternalLining.filepath || null,
          upper_filepath: this.newInternalLining.upper_filepath || null,
          lower_filepath: this.newInternalLining.lower_filepath || null,
        };

        await this.$axios.post("/v1/internal-linings/store", payload);

        this.$notify({
          type: "success",
          title: "Success",
          text: "Internal Lining added successfully!",
        });

        this.$emit("saved");
        this.closeModal();
      } catch (error) {
        console.error("Error adding Internal Lining:", error);
        this.$notify({
          type: "error",
          title: "Error",
          text: "Failed to add Internal Lining.",
        });
      } finally {
        this.loading = false;
      }
    },

    resetForm() {
      this.newInternalLining = {
        name: "",
        price: "",
        filepath: "",
        upper_filepath: "",
        lower_filepath: "",
      };
    },

    closeModal() {
      this.$emit("update:show", false);
      this.resetForm();
    },
  },
};
</script>
