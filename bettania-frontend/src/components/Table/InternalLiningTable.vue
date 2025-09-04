<template>
  <div class="mx-16 mb-4">
    <div class="my-6 flex flex-wrap items-center justify-between gap-4">
      <BaseIconButton
        label="Add Internal Lining"
        icon="ri-add-line"
        variant="default"
        aos="fade-up"
        @click="showAddModal = true"
      />
      <SearchBar
        v-model="params.search_global"
        @search="fetchInternalLining"
      />
    </div>

    <Pagination
      :pagination="pagination"
      @page-change="changePage"
    />

    <Spinner
      v-if="loading"
      class="col-span-full"
      label="Loading Internal Linings..."
    />

    <div
      v-if="!loading && internalLinings.length"
      class="grid grid-cols-1
      sm:grid-cols-2
      md:grid-cols-3
      lg:grid-cols-4
      gap-6"
    >
<div
  v-for="(internalLining, index) in internalLinings"
  :key="internalLining.internalLining_id || index"
  class="bg-white border rounded-lg shadow hover:shadow-lg transition overflow-hidden"
  data-aos="fade-up"
  :data-aos-delay="index * 100"
>
  <!-- Images Grid -->
  <div class="grid grid-cols-3 gap-1 h-40">
    <img
      v-if="internalLining.internal_linings_filepath"
      :src="filePath(internalLining.internal_linings_filepath)"
      alt="Main"
      class="w-full h-full object-cover"
    />
    <img
      v-if="internalLining.internal_linings_upper_filepath"
      :src="filePath(internalLining.internal_linings_upper_filepath)"
      alt="Upper"
      class="w-full h-full object-cover"
    />
    <img
      v-if="internalLining.internal_linings_lower_filepath"
      :src="filePath(internalLining.internal_linings_lower_filepath)"
      alt="Lower"
      class="w-full h-full object-cover"
    />
  </div>

  <!-- Content -->
  <div class="p-4">
    <h3 class="font-bold text-lg mb-2">
      {{ internalLining.internal_linings_name }}
    </h3>
    <p class="text-gray-600">
      <span class="font-semibold">Price:</span>
      {{ internalLining.internal_linings_price ? '$' + internalLining.internal_linings_price : 'N/A' }}
    </p>
  </div>

  <!-- Actions -->
  <div class="p-4 flex justify-end gap-2">
    <button @click="openEditModal(internalLining)">
      <i class="ri-edit-2-line hover:text-deep-plum"></i>
    </button>
    <button @click="openDeleteModal(internalLining)">
      <i class="ri-delete-bin-line hover:text-red-500"></i>
    </button>
  </div>
</div>

    </div>

    <p
      v-if="!loading && !internalLinings.length"
      class="bg-gray-200 col-span-full text-center text-black py-8"
      data-aos="fade-up"
      data-aos-delay="100"
      data-aos-duration="600"
    >
      No Internal Linings found.
    </p>

    <!-- Add Modal -->
    <AddInternalLiningModal
      :show="showAddModal"
      @update:show="showAddModal = $event"
      @saved="fetchInternalLining"
    />

    <!-- Edit Modal -->
    <EditInternalLiningModal
      :show="showEditModal"
      :internal="selectedInternalLiningToEdit"
      @update:show="showEditModal = $event"
      @updated="fetchInternalLining"
    />

    <!-- Delete Modal -->
    <DeleteInternalLiningModal
      :show="showDeleteModal"
      :internal="selectedInternalLiningToDelete"
      @update:show="showDeleteModal = $event"
      @deleted="fetchInternalLining"
    />
  </div>
</template>

<script>
import BaseIconButton from "@/components/Base/BaseIconButton.vue";
import SearchBar from "@/components/SearchBar.vue";
import Pagination from "@/components/Pagination.vue";
import Spinner from "@/components/Spinner.vue";
import AddInternalLiningModal from "@/components/Modal/InternalLining/AddInternalLiningModal.vue";
import EditInternalLiningModal from "@/components/Modal/InternalLining/EditInternalLiningModal.vue";
import DeleteInternalLiningModal from "@/components/Modal/InternalLining/DeleteInternalLiningModal.vue";

export default {
  components: {
    BaseIconButton,
    SearchBar,
    Pagination,
    Spinner,
    AddInternalLiningModal,
    EditInternalLiningModal,
    DeleteInternalLiningModal,
  },
  data() {
    return {
      showAddModal: false,
      showEditModal: false,
      showDeleteModal: false,
      selectedInternalLiningToEdit: null,
      selectedInternalLiningToDelete: null,
      loading: false,
      internalLinings: [],
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
    async fetchInternalLining() {
      this.loading = true;
      try {
        const res = await this.$axios.post("/v1/internal-linings", this.params);

        this.internalLinings = Array.isArray(res.data.body) ? res.data.body : [];

        this.pagination = {
          current_page: res.data.details?.current_page || 1,
          last_page: res.data.details?.last_page || 1,
          total: res.data.details?.total || 0,
          from: res.data.details?.from || 0,
          to: res.data.details?.to || 0,
        };
      } catch (err) {
        console.error("Failed to fetch internalLinings:", err);
        this.$notify({
          type: "error",
          title: "Error",
          text: "Failed to load internalLinings.",
        });
      } finally {
        this.loading = false;
      }
    },
    changePage(page) {
      this.params.page = page;
      this.fetchInternalLining();
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString();
    },
    openEditModal(internal) {
      this.selectedInternalLiningToEdit = internal;
      this.showEditModal = true;
    },
    openDeleteModal(internal) {
      this.selectedInternalLiningToDelete = internal;
      this.showDeleteModal = true;
    },
    filePath(path) {
      return `${process.env.VUE_APP_FILE_PATH}${path}`;
    },
  },
  mounted() {
    this.fetchInternalLining();
  },
};
</script>
