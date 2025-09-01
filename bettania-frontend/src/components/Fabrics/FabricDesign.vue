<template>
  <div class="mx-16 mb-4">
    <div class="my-6 flex flex-wrap items-center justify-between gap-4">
      <BaseIconButton
        label="Add Fabric Design"
        icon="ri-add-line"
        variant="default"
        aos="fade-up"
        @click="showAddModal = true"
      />
      <SearchBar
        v-model="params.search_global"
        @search="fetchFabrics"
      />
    </div>

    <Pagination
      :pagination="pagination"
      @page-change="changePage"
    />

    <Spinner
      v-if="loading"
      class="col-span-full"
      label="Loading Fabrics..."
    />

    <BaseGrid
      v-else
      :items="formattedFabricsDesign"
      label="Fabrics"
      @edit="editFabric"
      @delete="deleteFabric"
    />

    <AddFabricModal
      :show="showAddModal"
      @update:show="val => showAddModal = val"
      @saved="fetchFabrics"
    />
    <EditFabricModal
      :show="showEditModal"
      :fabric="selectedFabric"
      @update:show="val => showEditModal = val"
      @saved="fetchFabrics"
    />
    <DeleteFabricModal
      :show="showDeleteModal"
      :fabric="selectedFabricToDelete"
      @update:show="val => showDeleteModal = val"
      @deleted="fetchFabrics"
    />
  </div>
</template>

<script>
import Spinner from "@/components/Spinner.vue";
import SearchBar from "@/components/SearchBar.vue";
import Pagination from "@/components/Pagination.vue";
import BaseIconButton from "@/components/Base/BaseIconButton.vue";
import BaseGrid from "@/components/Base/BaseGrid.vue";
import AddFabricModal from "@/components/Modal/AddFabricModal.vue";
import EditFabricModal from "@/components/Modal/EditFabricModal.vue";
import DeleteFabricModal from "@/components/Modal/DeleteFabricModal.vue";

export default {
  components: {
    Spinner,
    SearchBar,
    Pagination,
    BaseIconButton,
    BaseGrid,
    AddFabricModal,
    EditFabricModal,
    DeleteFabricModal},
  data() {
    return {
      fabrics: [],
      loading: false,
      showAddModal: false,
      showEditModal: false,
      showDeleteModal: false,
      selectedFabric: null,
      selectedFabricToDelete: null,
      pagination: {
        current_page: 1,
        last_page: 1,
        total: 0,
        from: 0,
        to: 0
      },
      params: {
        page: 1,
        show: 8, 
        search_global: "",
        list_orders: [
          {
            order_by: "fabric_designs_title",
            sort_order: "ASC"
          }
        ]
      },
    };
  },
  computed: {
    formattedFabricsDesign() {
      return this.fabrics.map(f => ({
        id: f.fabric_designs_id,
        image: f.fabric_designs_filepath,
        title: f.fabric_designs_title,
        subtitle: `Created: ${new Date(f.fabric_designs_created_at).toLocaleDateString()}`
      }));
    },
  },
  methods: {
    async fetchFabrics() {
      this.loading = true;
      try {
        const res = await this.$axios.post("/v1/fabric-designs", this.params);
        this.fabrics = res.data.body || [];
        this.pagination = res.data.details || { current_page: 1, last_page: 1, total: 0, from: 0, to: 0 };
      } catch (err) {
        console.error(err);
      } finally {
        this.loading = false;
      }
    },
    editFabric(fabric) {
      this.selectedFabric = fabric;
      this.showEditModal = true;
    },
    deleteFabric(fabric) {
      this.selectedFabricToDelete = fabric;
      this.showDeleteModal = true;
    },
    changePage(page) {
      this.params.page = page;
      this.fetchFabrics();
    },
  },
  mounted() { this.fetchFabrics(); },
};
</script>