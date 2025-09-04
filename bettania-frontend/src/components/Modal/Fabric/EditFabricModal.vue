<template>
  <div
    v-if="show"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
  >
    <div
      class="bg-white rounded-xl shadow-lg w-full max-w-2xl p-6 max-h-[90vh] overflow-auto"
      data-aos="zoom-in"
    >
      <h2 class="text-2xl font-bold mb-4">Edit Fabric</h2>

      <form @submit.prevent="updateFabric" class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
          <BaseInput
            label="Fabric Name"
            placeholder="Enter Fabric Name"
            v-model="editFabric.fabrics_name"
            required
          />

          <BaseInput
            label="Price"
            placeholder="Enter Price"
            v-model="editFabric.fabrics_price"
            required
          />

          <BaseInput
            label="Color"
            placeholder="Enter Color"
            v-model="editFabric.fabrics_color"
            required
          />

          <BaseInput
            label="Color Code"
            placeholder="Enter Color Code"
            v-model="editFabric.fabrics_color_code"
            required
          />

          <BaseInput
            label="Fabric Code"
            placeholder="Enter Fabric Code"
            v-model="editFabric.fabrics_fabric_code"
            required
          />

          <BaseInput
            label="Composition"
            placeholder="Enter Composition"
            v-model="editFabric.fabrics_composition"
            required
          />

          <BaseSelect
            label="Fabric Design"
            v-model="editFabric.fabrics_fabric_design_id"
            :options="fabricDesignOptions"
            placeholder="-- Select Fabric Design --"
            required
          />

          <BaseSelect
            label="Fabric Season"
            v-model="editFabric.fabrics_fabric_season_id"
            :options="fabricSeasonOptions"
            placeholder="-- Select Fabric Season --"
            required
          />

          <BaseSelect
            label="Fabric Material"
            v-model="editFabric.fabrics_fabric_material_id"
            :options="fabricMaterialOptions"
            placeholder="-- Select Fabric Material --"
            required
          />

          <BaseSelect
            label="Fabric Mill"
            v-model="editFabric.fabrics_fabric_mill_id"
            :options="fabricMillOptions"
            placeholder="-- Select Fabric Mill --"
            required
          />

          <div class="col-span-2">
            <label class="block text-sm font-medium mb-2">
                Fabric Image
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
                    Drag & drop or click to upload fabric
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
            :disabled="loading || !editFabric.fabrics_filepath"
            class="px-4 py-2 rounded-md bg-deep-plum text-white hover:bg-l-deep-plum"
          >
            {{ loading ? "Updating..." : "Update Fabric" }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import BaseInput from "@/components/Base/BaseInput.vue";
import BaseSelect from "@/components/Base/BaseSelect.vue";

export default {
  components: { BaseInput, BaseSelect },
  props: {
    show: { type: Boolean, required: true },
    fabric: { type: Object, required: true }, // incoming fabric data
  },
  data() {
    return {
      editFabric: { ...this.fabric }, // prefill with fabric data
      fabricDesignOptions: [],
      fabricSeasonOptions: [],
      fabricMaterialOptions: [],
      fabricMillOptions: [],
      previewImage: null,
      loading: false,
    };
  },
  watch: {
    fabric: {
        immediate: true,
        deep: true,
        handler(newVal) {
        this.editFabric = { ...newVal };

        if (newVal?.fabrics_filepath) {
            this.previewImage = process.env.VUE_APP_FILE_PATH + newVal.fabrics_filepath;
        } else {
            this.previewImage = null;
        }
        },
    },
  },
  mounted() {
    this.fetchFabricDesigns();
    this.fetchFabricSeasons();
    this.fetchFabricMaterials();
    this.fetchFabricMills();
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
        this.editFabric.fabrics_filepath = res.data.body.fabrics_filepath;
        this.previewImage = process.env.VUE_APP_FILE_PATH + res.data.body.fabrics_filepath;
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
    async fetchFabricDesigns() {
      try {
        const res = await this.$axios.post("/v1/fabric-designs", {
          page: 1,
          show: 50,
          list_orders: [{ sort_order: "ASC", order_by: "fabric_designs_title" }],
        });
        if (res.data?.body) {
          this.fabricDesignOptions = res.data.body.map((item) => ({
            id: item.fabric_designs_id,
            title: item.fabric_designs_title,
          }));
        }
      } catch (error) {
        this.$notify({ type: "error", title: "Error", text: "Could not load Fabric Designs." });
      }
    },
    async fetchFabricSeasons() {
      try {
        const res = await this.$axios.post("/v1/fabric-seasons", {
          page: 1,
          show: 50,
          list_orders: [{ sort_order: "ASC", order_by: "" }],
        });
        if (res.data?.body) {
          this.fabricSeasonOptions = res.data.body.map((item) => ({
            id: item.fabric_seasons_id,
            title: item.fabric_seasons_title,
          }));
        }
      } catch {
        this.$notify({ type: "error", title: "Error", text: "Could not load Fabric Seasons." });
      }
    },
    async fetchFabricMaterials() {
      try {
        const res = await this.$axios.post("/v1/fabric-materials", {
          page: 1,
          show: 50,
          list_orders: [{ sort_order: "ASC", order_by: "" }],
        });
        if (res.data?.body) {
          this.fabricMaterialOptions = res.data.body.map((item) => ({
            id: item.fabric_materials_id,
            title: item.fabric_materials_title,
          }));
        }
      } catch {
        this.$notify({ type: "error", title: "Error", text: "Could not load Fabric Materials." });
      }
    },
    async fetchFabricMills() {
      try {
        const res = await this.$axios.post("/v1/fabric-mills", {
          page: 1,
          show: 50,
        });
        if (res.data?.body) {
          this.fabricMillOptions = res.data.body.map((item) => ({
            id: item.fabric_mills_id,
            title: item.fabric_mills_title,
          }));
        }
      } catch {
        this.$notify({ type: "error", title: "Error", text: "Could not load Fabric Mills." });
      }
    },
    async updateFabric() {
        try {
            this.loading = true;

            const payload = {
            name: this.editFabric.fabrics_name,
            price: this.editFabric.fabrics_price,
            color: this.editFabric.fabrics_color,
            color_code: this.editFabric.fabrics_color_code,
            fabric_code: this.editFabric.fabrics_fabric_code,
            composition: this.editFabric.fabrics_composition,
            fabric_design_id: this.editFabric.fabrics_fabric_design_id,
            fabric_season_id: this.editFabric.fabrics_fabric_season_id,
            fabric_material_id: this.editFabric.fabrics_fabric_material_id,
            fabric_mill_id: this.editFabric.fabrics_fabric_mill_id,
            filepath: this.editFabric.fabrics_filepath,
            };

            await this.$axios.put(`/v1/fabrics/${this.editFabric.fabrics_id}`, payload);

            this.$notify({ type: "success", title: "Success", text: "Fabric updated successfully!" });
            this.$emit("saved");
            this.closeModal();
        } catch (error) {
            this.$notify({
            type: "error",
            title: "Error",
            text: error.response?.data?.message || "Failed to update Fabric.",
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
