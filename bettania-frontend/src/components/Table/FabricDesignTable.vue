<template>
  <div class="mx-16 mb-4">
    <div class="my-6 flex flex-wrap items-center justify-between gap-4">
      <BaseIconButton
        label="Add Design"
        icon="ri-add-line"
        variant="default"
        aos="fade-up"
        @click="showAddModal = true"
      />
      <SearchBar
        v-model="params.search_global"
        @search="fetchDesign"
      />
    </div>

    <Pagination
      :pagination="pagination"
      @page-change="changePage"
    />

    <Spinner
      v-if="loading"
      class="col-span-full"
      label="Loading Design..."
    />

    <BaseGrid
      v-else
      :items="formattedDesign"
      label="Designs"
      @edit="editDesign"
      @delete="deleteDesign"
    />

    <AddDesignModal
      :show="showAddModal"
      @update:show="val => showAddModal = val"
      @saved="fetchDesign"
    />
    <EditDesignModal
      :show="showEditModal"
      :design="selectedDesign"
      @update:show="val => showEditModal = val"
      @saved="fetchDesign"
    />
    <DeleteDesignModal
      :show="showDeleteModal"
      :design="selectedDesignToDelete"
      @update:show="val => showDeleteModal = val"
      @deleted="fetchDesign"
    />
  </div>
</template>

<script>
import Spinner from "@/components/Spinner.vue";
import SearchBar from "@/components/SearchBar.vue";
import Pagination from "@/components/Pagination.vue";
import BaseIconButton from "@/components/Base/BaseIconButton.vue";
import BaseGrid from "@/components/Base/BaseGrid.vue";
import AddDesignModal from "@/components/Modal/Fabric/AddDesignModal.vue";
import EditDesignModal from "@/components/Modal/Fabric/EditDesignModal.vue";
import DeleteDesignModal from "@/components/Modal/Fabric/DeleteDesignModal.vue";

export default {
  components: {
    Spinner,
    SearchBar,
    Pagination,
    BaseIconButton,
    BaseGrid,
    AddDesignModal,
    EditDesignModal,
    DeleteDesignModal
  },
  data() {
    return {
      designs: [],
      loading: false,
      showAddModal: false,
      showEditModal: false,
      showDeleteModal: false,
      selectedDesign: null,
      selectedDesignToDelete: null,
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
    formattedDesign() {
      return this.designs.map(f => ({
        id: f.fabric_designs_id,
        image: f.fabric_designs_filepath,
        title: f.fabric_designs_title,
        subtitle: `Created: ${new Date(f.fabric_designs_created_at).toLocaleDateString()}`
      }));
    },
  },
  methods: {
    async fetchDesign() {
      this.loading = true;
      try {
        const res = await this.$axios.post("/v1/fabric-designs", this.params);
        this.designs = res.data.body || [];
        this.pagination = res.data.details || { current_page: 1, last_page: 1, total: 0, from: 0, to: 0 };
      } catch (err) {
        console.error(err);
      } finally {
        this.loading = false;
      }
    },
    editDesign(design) {
      this.selectedDesign = design;
      this.showEditModal = true;
    },
    deleteDesign(design) {
      this.selectedDesignToDelete = design;
      this.showDeleteModal = true;
    },
    changePage(page) {
      this.params.page = page;
      this.fetchDesign();
    },
  },
  mounted() { this.fetchDesign(); },
};
</script>