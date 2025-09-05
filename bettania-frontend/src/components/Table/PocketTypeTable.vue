<template>
  <div class="mx-16 mb-4">
    <div class="my-6 flex flex-wrap items-center justify-between gap-4">
      <BaseIconButton
        label="Add Pocket Type"
        icon="ri-add-line"
        variant="default"
        aos="fade-up"
        @click="showAddModal = true"
      />
      <SearchBar
        v-model="params.search_global"
        @search="fetchPocketTypes"
      />
    </div>

    <Pagination
      :pagination="pagination"
      @page-change="changePage"
    />

    <Spinner
      v-if="loading"
      class="col-span-full"
      label="Loading Pocket Types..."
    />

    <div
      v-else-if="pocketTypes.length === 0"
      class="bg-gray-200
      col-span-full
      text-center
      text-black py-8
      rounded-lg"
      data-aos="fade-up"
      data-aos-delay="100"
      data-aos-duration="600"
    >
      <p>
        No Pocket Types Found
      </p>
    </div>

    <div
      v-else
      class="grid grid-cols-1
      md:grid-cols-2
      lg:grid-cols-3
      gap-6 mt-6"
    >
      <div
        v-for="(pocketType, index) in pocketTypes"
        :key="pocketType.pocket_types_id"
        class="p-4 bg-white
        rounded-xl shadow
        hover:shadow-lg
        transition relative"
        data-aos="fade-up"
        :data-aos-delay="index * 100"
      >
        <h3 class="text-lg font-semibold text-gray-800">
          {{ pocketType.pocket_types_name }}
        </h3>

        <p class="text-sm text-gray-600 mt-1">
          Created: {{ formatDate(pocketType.pocket_types_created_at) }}
        </p>

        <div class="absolute top-3 right-3 flex space-x-2">
          <button @click="openEditModal(pocketType)">
            <i class="ri-edit-2-line hover:text-deep-plum"></i>
          </button>
          <button @click="openDeleteModal(pocketType)">
            <i class="ri-delete-bin-line hover:text-red-500"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Modals -->
    <AddPocketTypeModal
      :show="showAddModal"
      @update:show="showAddModal = $event"
      @saved="fetchPocketTypes"
    />
    <EditPocketTypeModal
      :show="showEditModal"
      :pocketType="selectedPocketTypeToEdit"
      @update:show="showEditModal = $event"
      @saved="fetchPocketTypes"
    />
    <DeletePocketTypeModal
      :show="showDeleteModal"
      :pocketType="selectedPocketTypeToDelete"
      @update:show="showDeleteModal = $event"
      @deleted="fetchPocketTypes"
    />
  </div>
</template>

<script>
import BaseIconButton from "@/components/Base/BaseIconButton.vue";
import SearchBar from "@/components/SearchBar.vue";
import Pagination from "@/components/Pagination.vue";
import Spinner from "@/components/Spinner.vue";
import AddPocketTypeModal from "@/components/Modal/Pocket/AddPocketTypeModal.vue";
import EditPocketTypeModal from "@/components/Modal/Pocket/EditPocketTypeModal.vue";
import DeletePocketTypeModal from "@/components/Modal/Pocket/DeletePocketTypeModal.vue";

export default {
  components: {
    BaseIconButton,
    SearchBar,
    Pagination,
    Spinner,
    AddPocketTypeModal,
    EditPocketTypeModal,
    DeletePocketTypeModal,
  },
  data() {
    return {
      showAddModal: false,
      showEditModal: false,
      showDeleteModal: false,
      selectedPocketTypeToEdit: null,
      selectedPocketTypeToDelete: null,
      loading: false,
      pocketTypes: [],
      pagination: {
        current_page: 1,
        last_page: 1,
        total: 0,
        from: 0,
        to: 0,
      },
      params: {
        page: 1,
        show: 8,
        search_global: "",
        list_orders: [
          {
            order_by: "",
            sort_order: "ASC",
          },
        ],
      },
    };
  },

  methods: {
    async fetchPocketTypes() {
      this.loading = true;
      try {
        const res = await this.$axios.post("/v1/pocket-types", this.params);

        this.pocketTypes = Array.isArray(res.data.body) ? res.data.body : [];

        this.pagination = {
          current_page: res.data.details?.current_page || 1,
          last_page: res.data.details?.last_page || 1,
          total: res.data.details?.total || 0,
          from: res.data.details?.from || 0,
          to: res.data.details?.to || 0,
        };
      } catch (err) {
        console.error("Failed to fetch pocket types:", err);
        this.$notify({
          type: "error",
          title: "Error",
          text: "Failed to load pocket types.",
        });
      } finally {
        this.loading = false;
      }
    },
    changePage(page) {
      this.params.page = page;
      this.fetchPocketTypes();
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString();
    },
    openEditModal(pocketType) {
      this.selectedPocketTypeToEdit = pocketType;
      this.showEditModal = true;
    },
    openDeleteModal(pocketType) {
      this.selectedPocketTypeToDelete = pocketType;
      this.showDeleteModal = true;
    },
  },
  mounted() {
    this.fetchPocketTypes();
  },
};
</script>
