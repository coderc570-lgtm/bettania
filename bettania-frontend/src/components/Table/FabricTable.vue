<template>
  <div class="mx-16 mb-4">
    <div
      class="my-6 flex
      flex-wrap
      items-center
      justify-between
      gap-4"
    >
      <BaseIconButton
        label="Add Fabric"
        icon="ri-add-line"
        variant="default"
        aos="fade-up"
        @click="showAddModal = true"
      />
      <SearchBar
        v-model="params.search_global"
        @search="fetchFabric"
      />
    </div>

    <Pagination
      :pagination="pagination"
      @page-change="changePage"
      v-if="fabrics.length"
    />

    <Spinner
      v-if="loading"
      class="col-span-full"
      label="Loading Fabrics..."
    />

    <div
      v-if="!loading && fabrics.length"
      class="grid grid-cols-1
      sm:grid-cols-2
      md:grid-cols-3
      lg:grid-cols-4
      gap-6"
    >
      <div
        v-for="(fabric, index) in fabrics"
        :key="fabric.id || index"
        class="bg-white border
        rounded-lg shadow
        hover:shadow-lg
        transition
        overflow-hidden"
        data-aos="fade-up"
        :data-aos-delay="index * 100"
      >
        <img
          v-if="fabric.fabrics_filepath"
          :src="filePath(fabric.fabrics_filepath)"
          alt="Fabric Image"
          class="w-full h-40 object-cover"
        />
        <div class="p-4">
          <h3 class="font-bold text-lg mb-2">
            {{ fabric.fabrics_name }}
          </h3>
          <p class="text-gray-600 mb-1"><span class="font-semibold">
            Type:</span> {{ fabric.fabrics_name || 'N/A' }}
          </p>
          <p class="text-gray-600 mb-1"><span class="font-semibold">
            Color:</span> {{ fabric.fabrics_color || 'N/A' }}
          </p>
          <p class="text-gray-600"><span class="font-semibold">
            Price:</span> {{ fabric.fabrics_price ? '$' + fabric.fabrics_price : 'N/A' }}
          </p>
        </div>

        <div class="p-4 flex justify-end gap-2">
          <button @click="updateDesign(fabric)">
            <i class="ri-edit-2-line hover:text-deep-plum"></i>
          </button>
          <button @click="deleteDesign(fabric)">
            <i class="ri-delete-bin-line hover:text-red-500"></i>
          </button>
        </div>
      </div>
    </div>

    <p
      v-if="!loading && !fabrics.length"
      class="bg-gray-200 col-span-full text-center text-black py-8"
      data-aos="fade-up"
      data-aos-delay="100"
      data-aos-duration="600"
    >
      No fabrics found.
    </p>

    <AddFabricModal
      :show="showAddModal"
      @update:show="val => showAddModal = val"
      @saved="fetchFabric"
    />

    <EditFabricModal 
      :show="showEditModal" 
      :fabric="selectedFabric" 
      @update:show="val => showEditModal = val"
      @saved="fetchFabric"
    />

    <DeleteFabricModal
      :show="showDeleteModal"
      :fabric="selectedFabricToDelete"
      @update:show="val => showDeleteModal = val"
      @deleted="fetchFabric"
    />
  </div>
</template>

<script>
import Spinner from "@/components/Spinner.vue";
import SearchBar from "@/components/SearchBar.vue";
import Pagination from "@/components/Pagination.vue";
import BaseIconButton from "@/components/Base/BaseIconButton.vue";
import AddFabricModal from "@/components/Modal/Fabric/AddFabricModal.vue";
import EditFabricModal from "@/components/Modal/Fabric/EditFabricModal.vue";
import DeleteFabricModal from "@/components/Modal/Fabric/DeleteFabricsModal.vue";

export default {
  components: {
    Spinner,
    SearchBar,
    Pagination,
    AddFabricModal,
    BaseIconButton,
    EditFabricModal,
    DeleteFabricModal,
  },
  data() {
    return {
      showAddModal: false,
      showEditModal: false,
      showDeleteModal: false,
      selectedFabric: null,
      selectedFabricToDelete: null,
      fabrics: [],
      loading: false,
      pagination: {},
      params: {
        search_global: "",
        page: 1,
        show: 12,
        list_orders: [
          {
            order_by: "fabrics",
            sort_order: "ASC"
          }
        ]
      },
    };
  },
  methods: {
    async fetchFabric() {
      this.loading = true;
      try {
        const response = await this.$axios.post("/v1/fabrics/", this.params);
        this.fabrics = response.data.body || [];
        console.log(this.fabrics);
        this.pagination = response.data.details || { current_page: 1, last_page: 1, total: 0, from: 0, to: 0 };
      } catch (error) {
        console.error("Error fetching fabrics:", error);
      } finally {
        this.loading = false;
      }
    },
    changePage(page) {
      this.params.page = page;
      this.fetchFabric();
    },
    filePath(path) {
      return `${process.env.VUE_APP_FILE_PATH}${path}`;
    },
    updateDesign(fabrics) {
      this.selectedFabric = fabrics;
      this.showEditModal = true;
    },
    deleteDesign(fabrics) {
      this.selectedFabricToDelete = fabrics;
      this.showDeleteModal = true;
    },
  },
  mounted() {
    this.fetchFabric();
  },
};
</script>