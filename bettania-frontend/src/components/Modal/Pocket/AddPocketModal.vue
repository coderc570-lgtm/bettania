<template>
  <div
    v-if="show"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
  >
    <div
      class="bg-white rounded-xl shadow-lg w-full max-w-md p-6"
      data-aos="zoom-in"
    >
      <h2 class="text-2xl font-bold mb-4">
        Add Pocket
      </h2>

      <form @submit.prevent="submitPocket" class="space-y-4">
        <BaseInput
          label="Pocket Name"
          placeholder="Enter Pocket Name"
          v-model="newPocket.name"
          required
        />

        <BaseInput
          label="Description"
          placeholder="Enter Description"
          v-model="newPocket.description"
          required
        />

        <BaseInput
          label="Price"
          type="number"
          placeholder="Enter Price"
          v-model="newPocket.price"
          required
        />

        <BaseImageUpload
          formLabel="Pocket Image"
          folder="Pocket"
          label="Drag & drop or click to upload pocket"
          loadingMessage="Uploading Pocket..."
          @uploaded="newPocket.filepath = $event.path; newPocket.file = $event.file; newPocket.preview = $event.preview"
        />

        <BaseSelect
          label="Pocket Type"
          v-model="newPocket.pocket_type_id"
          :options="pocketTypeOptions"
          placeholder="-- Select Pocket Type --"
          required
        />

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
            :disabled="loading || !newPocket.name || !newPocket.pocket_type_id || !newPocket.filepath"
            class="px-4 py-2 rounded-md bg-deep-plum text-white hover:bg-l-deep-plum"
          >
            {{ loading ? "Adding..." : "Add Pocket" }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import BaseInput from "@/components/Base/BaseInput.vue";
import BaseImageUpload from "@/components/Base/BaseImageUpload.vue";
import BaseSelect from "@/components/Base/BaseSelect.vue";

export default {
  components: {
    BaseInput,
    BaseImageUpload,
    BaseSelect,
  },
  props: {
    show: { type: Boolean, required: true },
  },
  data() {
    return {
      newPocket: {
        name: "",
        description: "",
        price: "",
        filepath: "",
        pocket_type_id: null,
        file: null,
        preview: "",
      },
      loading: false,
      pocketTypeOptions: [],
    };
  },
  methods: {
    async fetchPocketTypes() {
      try {
        const payload = {
          search_global: null,
          page: 1,
          show: 100,
          list_orders: [{ order_by: "pocket_types_name", sort_order: "ASC" }],
          search: [],
        };
        const res = await this.$axios.post("/v1/pocket-types/", payload);

        this.pocketTypeOptions = Array.isArray(res.data.body)
          ? res.data.body.map((item) => ({
              id: item.pocket_types_id,
              title: item.pocket_types_name,
            }))
          : [];
      } catch (err) {
        console.error("Failed to fetch pocket types:", err);
        this.$notify({
          type: "error",
          title: "Error",
          text: "Failed to load pocket types.",
        });
      }
    },
    async submitPocket() {
      this.loading = true;
      try {
        const payload = {
          name: this.newPocket.name,
          description: this.newPocket.description,
          filepath: this.newPocket.filepath,
          pocket_type_id: this.newPocket.pocket_type_id,
          price: this.newPocket.price,
        };

        await this.$axios.post("/v1/pockets/store", payload);

        this.$notify({
          type: "success",
          title: "Success",
          text: "Pocket added successfully!",
        });

        this.$emit("saved");
        this.resetForm();
        this.closeModal();
      } catch (error) {
        console.error("Error adding pocket:", error);
        this.$notify({
          type: "error",
          title: "Error",
          text: "Failed to add pocket.",
        });
      } finally {
        this.loading = false;
      }
    },
    resetForm() {
      this.newPocket = {
        name: "",
        description: "",
        price: "",
        filepath: "",
        pocket_type_id: null,
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
  mounted() {
    this.fetchPocketTypes();
  },
};
</script>
