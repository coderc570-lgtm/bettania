<template>
  <div
    v-if="show"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
  >
    <div
      class="bg-white rounded-xl shadow-lg w-full max-w-2xl p-6 max-h-[90vh] overflow-auto"
      data-aos="zoom-in"
    >
      <h2 class="text-2xl font-bold mb-4">Add Fabric</h2>

      <form @submit.prevent="submitFabric" class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
          <BaseInput
            label="Fabric Name"
            placeholder="Enter Fabric Name"
            v-model="newFabric.name"
            required
          />

          <BaseInput
            label="Price"
            placeholder="Enter Price"
            v-model="newFabric.price"
            required
          />

         
          <BaseInput
            label="Color"
            placeholder="Enter Color"
            v-model="newFabric.color"
            required
          />

          <BaseInput
            label="Color Code"
            placeholder="Enter Color Code"
            v-model="newFabric.colorCode"
            required
          />

          <BaseInput
            label="Fabric Code"
            placeholder="Enter Fabric Code"
            v-model="newFabric.fabricCode"
            required
          />

          <BaseInput
            label="Composition"
            placeholder="Enter Composition"
            v-model="newFabric.composition"
            required
          />

          <BaseSelect
            label="Fabric Design"
            v-model="newFabric.fabricDesign"
            :options="fabricDesignOptions"
            placeholder="-- Select Fabric Design --"
            required
          />

          <BaseSelect
            label="Fabric Season"
            v-model="newFabric.fabricSeason"
            :options="fabricSeasonOptions"
            placeholder="-- Select Fabric Season --"
            required
          />

          <BaseSelect
            label="Fabric Material"
            v-model="newFabric.fabricMaterial"
            :options="fabricMaterialOptions"
            placeholder="-- Select Fabric Material --"
            required
          />

          <BaseSelect
            label="Fabric Mill"
            v-model="newFabric.fabricMill"
            :options="fabricMillOptions"
            placeholder="-- Select Fabric Mill --"
            required
          />

           <BaseImageUpload
            class="col-span-2"
            formLabel="Fabric Image"
            folder="Fabric"
            label="Drag & drop or click to upload fabric"
            loadingMessage="Uploading Fabric..."
            @uploaded="
              newFabric.filepath = $event.path;
              newFabric.file = $event.file;
              newFabric.preview = $event.preview
            "
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
            :disabled="loading || !newFabric.filepath"
            class="px-4 py-2 rounded-md bg-deep-plum text-white hover:bg-l-deep-plum"
          >
            {{ loading ? "Adding..." : "Add Fabric" }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import BaseImageUpload from "@/components/Base/BaseImageUpload.vue";
import BaseInput from "@/components/Base/BaseInput.vue";
import BaseSelect from "@/components/Base/BaseSelect.vue";

export default {
  components: {
    BaseImageUpload,
    BaseInput,
    BaseSelect,
  },
  props: {
    show: { type: Boolean, required: true },
  },
  data() {
    return {
      newFabric: {
        name: "",
        price: "",
        filepath: "",
        file: null,
        preview: "",
        color: "",
        colorCode: "",
        fabricCode: "",
        composition: "",
        fabricDesign: null,
        fabricSeason: null,
        fabricMaterial: null,
        fabricMill: null,
      },
      fabricDesignOptions: [],
      fabricSeasonOptions: [],
      fabricMaterialOptions: [],
      fabricMillOptions: [],
      loading: false,
    };
  },
  mounted() {
    this.fetchFabricDesigns();
    this.fetchFabricSeasons();
    this.fetchFabricMaterials();
    this.fetchFabricMills();
  },
  methods: {
    async fetchFabricDesigns() {
      try {
        const res = await this.$axios.post("/v1/fabric-designs", {
          search_global: null,
          page: 1,
          show: 50,
          list_orders: [{ sort_order: "ASC", order_by: "fabric_designs_title" }],
          search: [{ s: null, key: null }],
        });
        if (res.data?.body) {
          this.fabricDesignOptions = res.data.body.map((item) => ({
            id: item.fabric_designs_id,
            title: item.fabric_designs_title,
          }));
        }
      } catch (error) {
        console.error(error);
        this.$notify({ type: "error", title: "Error", text: "Could not load Fabric Designs." });
      }
    },
    async fetchFabricSeasons() {
      try {
        const res = await this.$axios.post("/v1/fabric-seasons", {
          search_global: null,
          page: 1,
          show: 50,
          list_orders: [{ sort_order: "ASC", order_by: "fabric_seasons_title" }],
          search: [{ s: null, key: null }],
        });
        if (res.data?.body) {
          this.fabricSeasonOptions = res.data.body.map((item) => ({
            id: item.fabric_seasons_id,
            title: item.fabric_seasons_title,
          }));
        }
      } catch (error) {
        console.error(error);
        this.$notify({ type: "error", title: "Error", text: "Could not load Fabric Seasons." });
      }
    },
    async fetchFabricMaterials() {
      try {
        const res = await this.$axios.post("/v1/fabric-materials", {
          search_global: null,
          page: 1,
          show: 50,
          list_orders: [{ sort_order: "ASC", order_by: "fabric_materials.title" }],
          search: [{ s: null, key: null }],
        });
        if (res.data?.body) {
          this.fabricMaterialOptions = res.data.body.map((item) => ({
            id: item.fabric_materials_id,
            title: item.fabric_materials_title,
          }));
        }
      } catch (error) {
        console.error(error);
        this.$notify({ type: "error", title: "Error", text: "Could not load Fabric Materials." });
      }
    },
    async fetchFabricMills() {
      try {
        const res = await this.$axios.post("/v1/fabric-mills", {
          search_global: null,
          page: 1,
          show: 50,
        });
        if (res.data?.body) {
          this.fabricMillOptions = res.data.body.map((item) => ({
            id: item.fabric_mills_id,
            title: item.fabric_mills_title,
          }));
        }
      } catch (error) {
        console.error(error);
        this.$notify({ type: "error", title: "Error", text: "Could not load Fabric Mills." });
      }
    },
    async submitFabric() {
      try {
        this.loading = true;
        const formData = new FormData();
        Object.keys(this.newFabric).forEach((key) => {
          formData.append(key, this.newFabric[key]);
        });
        await this.$axios.post("/v1/fabrics/store", formData);
        this.$notify({ type: "success", title: "Success", text: "Fabric added successfully!" });
        this.$emit("saved");
        this.resetForm();
        this.closeModal();
      } catch (error) {
        console.error(error);
        this.$notify({ type: "error", title: "Error", text: "Failed to add Fabric." });
      } finally {
        this.loading = false;
      }
    },
    closeModal() {
      this.$emit("update:show", false);
      this.resetForm();
    },
    resetForm() {
      this.newFabric = {
        name: "",
        price: "",
        filepath: "",
        file: null,
        preview: "",
        color: "",
        colorCode: "",
        fabricCode: "",
        composition: "",
        fabricDesign: null,
        fabricSeason: null,
        fabricMaterial: null,
        fabricMill: null,
      };
      this.loading = false;
    },
  },
};
</script>
