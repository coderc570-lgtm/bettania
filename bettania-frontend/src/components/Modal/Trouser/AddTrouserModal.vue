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
        Add Trouser
      </h2>

      <form @submit.prevent="submitTrouser" class="space-y-4">
        <div class="grid grid-cols-1 gap-4">
          <BaseInput
            label="Trouser Name"
            placeholder="Enter Trouser Name"
            v-model="newTrouser.name"
            required
          />

          <BaseInput
            label="Price"
            type="number"
            placeholder="Enter Price"
            v-model="newTrouser.price"
            required
          />

          <BaseImageUpload
            formLabel="Trouser Image"
            folder="Trouser"
            label="Drag & drop or click to upload trouser"
            loadingMessage="Uploading Trouser..."
            @uploaded="newTrouser.filepath = $event.path; newTrouser.file = $event.file; newTrouser.preview = $event.preview"
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
            :disabled="loading || !newTrouser.filepath"
            class="px-4 py-2 rounded-md bg-deep-plum text-white hover:bg-l-deep-plum"
          >
            {{ loading ? "Adding..." : "Add Trouser" }}
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
      newTrouser: {
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
    async submitTrouser() {
      this.loading = true;
      try {
        const formData = new FormData();
        formData.append("name", this.newTrouser.name);
        formData.append("price", this.newTrouser.price);
        formData.append("filepath", this.newTrouser.filepath);

        await this.$axios.post("/v1/trouser-fabrics/store", formData);

        this.$notify({
          type: "success",
          title: "Success",
          text: "Trouser added successfully!",
        });
        this.$emit("saved");
        this.resetForm();
        this.closeModal();
      } catch (error) {
        console.error("Error adding Trouser:", error);
        this.$notify({
          type: "error",
          title: "Error",
          text: "Failed to add Trouser.",
        });
      } finally {
        this.loading = false;
      }
    },

    resetForm() {
      this.newTrouser = {
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
