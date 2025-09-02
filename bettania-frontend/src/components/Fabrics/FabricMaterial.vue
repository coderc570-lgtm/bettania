<template>
  <div class="mx-16 mb-4">
    <div class="my-6 flex flex-wrap items-center justify-between gap-4">
      <BaseIconButton
        label="Add Material"
        icon="ri-add-line"
        variant="default"
        aos="fade-up"
        @click="showAddModal = true"
      />
      <SearchBar
        v-model="params.search_global"
        @search="fetchMaterials"
      />
    </div>

    <Pagination
      :pagination="pagination"
      @page-change="changePage"
    />

    <Spinner
      v-if="loading"
      class="col-span-full"
      label="Loading Materials..."
    />

    <div
      v-else-if="materials.length === 0"
      class="bg-gray-200
      col-span-full text-center
      text-black py-8 rounded-lg"
      data-aos="fade-up"
      data-aos-delay="100"
      data-aos-duration="600"
    >
      <p>No Material Found</p>
    </div>

    <div
      v-else
      class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6"
    >
      <div
        v-for="(material, index) in materials"
        :key="material.fabric_materials_id"
        class="p-4 bg-white rounded-xl shadow hover:shadow-lg transition relative"
        data-aos="fade-up"
        :data-aos-delay="index * 100"
      >
        <h3 class="text-lg font-semibold text-gray-800">
          {{ material.fabric_materials_title }}
        </h3>

        <p class="text-sm text-gray-600 mt-1">
          Main: {{ getMaterialTitleById(material.fabric_materials_head_fabric_material_id) }}
        </p>

        <div class="absolute top-3 right-3 flex space-x-2">
          <button @click="openEditModal(material)">
            <i class="ri-edit-2-line hover:text-deep-plum"></i>
          </button>
          <button @click="openDeleteModal(material)">
            <i class="ri-delete-bin-line hover:text-red-500"></i>
          </button>
        </div>
      </div>
    </div>

    <AddMaterialModal
      :show="showAddModal"
      :materials="materials"
      @update:show="showAddModal = $event"
      @saved="fetchMaterials"
    />
    <EditMaterialModal
      :show="showEditModal"
      :material="selectedMaterial"
      :materials="materials"
      @update:show="showEditModal = $event"
      @updated="fetchMaterials"
    />

    <DeleteMaterialModal
      :show="showDeleteModal"
      :material="selectedMaterial"
      @update:show="showDeleteModal = $event"
      @deleted="fetchMaterials"
    />
  </div>
</template>

<script>
import BaseIconButton from "@/components/Base/BaseIconButton.vue";
import SearchBar from "@/components/SearchBar.vue";
import Pagination from "@/components/Pagination.vue";
import Spinner from "@/components/Spinner.vue";
import AddMaterialModal from "@/components/Modal/Fabric/AddMaterialModal.vue";
import EditMaterialModal from "@/components/Modal/Fabric/EditMaterialModal.vue";
import DeleteMaterialModal from "@/components/Modal/Fabric/DeleteMaterialModal.vue";

export default {
  components: {
    BaseIconButton,
    SearchBar,
    Pagination,
    Spinner,
    AddMaterialModal,
    EditMaterialModal,
    DeleteMaterialModal
  },
  data() {
    return {
      showAddModal: false,
      showEditModal: false,
      showDeleteModal: false,
      selectedMaterial: null,
      loading: false,
      materials: [],
      pagination: {
        current_page: 1,
        last_page: 1,
        total: 0,
        from: 0,
        to: 0,
      },
      params: {
        page: 1,
        show: 9,
        show_only_heads: false,
        search_global: "",
        list_orders: [
          {
            order_by: "fabric_materials.title",
            sort_order: "ASC",
          },
        ],
        search: [],
      },
    };
  },
  methods: {
    async fetchMaterials() {
      this.loading = true;
      try {
        const res = await this.$axios.post("/v1/fabric-materials", this.params);

        this.materials = Array.isArray(res.data.body) ? res.data.body : [];

        this.pagination = {
          current_page: res.data.details?.current_page || 1,
          last_page: res.data.details?.last_page || 1,
          total: res.data.details?.total || 0,
          from: res.data.details?.from || 0,
          to: res.data.details?.to || 0,
        };
      } catch (err) {
        console.error("Failed to fetch materials:", err);
        this.$notify({
          type: "error",
          title: "Error",
          text: "Failed to load Materials.",
        });
      } finally {
        this.loading = false;
      }
    },
    changePage(page) {
      this.params.page = page;
      this.fetchMaterials();
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString();
    },
    getMaterialTitleById(id) {
      const found = this.materials.find(m => m.fabric_materials_id === id);
      return found ? found.fabric_materials_title : "N/A";
    },
    openEditModal(material) {
      this.selectedMaterial = material;
      this.showEditModal = true;
    },
    openDeleteModal(material) {
      this.selectedMaterial = material;
      this.showDeleteModal = true;
    }
  },
  mounted() {
    this.fetchMaterials();
  },
};
</script>