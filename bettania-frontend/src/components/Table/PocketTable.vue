<template>
  <div class="mx-16 mb-4">
    <div class="my-6 flex flex-wrap items-center justify-between gap-4">
      <BaseIconButton
        label="Add Pocket"
        icon="ri-add-line"
        variant="default"
        aos="fade-up"
        @click="showAddModal = true"
      />
      <SearchBar
        v-model="params.search_global"
        @search="fetchPockets"
      />
    </div>

    <Pagination
      :pagination="pagination"
      @page-change="changePage"
    />

    <Spinner
      v-if="loading"
      class="col-span-full"
      label="Loading Pockets..."
    />

    <div
      v-else-if="pockets.length === 0"
      class="bg-gray-200 col-span-full text-center text-black py-8 rounded-lg"
      data-aos="fade-up"
      data-aos-delay="100"
      data-aos-duration="600"
    >
      <p>No Pockets Found</p>
    </div>

    <div
        v-else
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6"
    >
        <div
            v-for="(pocket, index) in pockets"
            :key="pocket.pockets_id"
            class="p-4 bg-white rounded-xl shadow hover:shadow-lg transition flex flex-col"
            data-aos="fade-up"
            :data-aos-delay="index * 100"
        >
            <img
            v-if="pocket.pockets_filepath"
            :src="filePath(pocket.pockets_filepath)"
            alt="Pocket Image"
            class="w-full h-40 object-cover rounded-lg mb-3"
            />

            <h3 class="text-lg font-semibold text-gray-800">
            {{ pocket.pockets_name }}
            </h3>

            <p class="text-sm text-gray-500 mt-1">
            Type: {{ pocket.pockets_pocket_type_id_foreign_name || "N/A" }}
            </p>

            <p class="text-sm text-gray-600 mt-1">
            Price: ₱{{ pocket.pockets_price }}
            </p>

            <p class="text-sm text-gray-600 mt-1 flex-grow">
            {{ pocket.pockets_description }}
            </p>

            <p class="text-xs text-gray-400 mt-2">
            Created: {{ formatDate(pocket.pockets_created_at) }}
            </p>

            <div class="mt-4 flex justify-end space-x-2">
            <button @click="openEditModal(pocket)">
                <i class="ri-edit-2-line hover:text-deep-plum"></i>
            </button>
            <button @click="openDeleteModal(pocket)">
                <i class="ri-delete-bin-line hover:text-red-500"></i>
            </button>
            </div>
        </div>
    </div>


    <AddPocketModal
      :show="showAddModal"
      @update:show="showAddModal = $event"
      @saved="fetchPockets"
    />
    <!-- <EditPocketModal
      :show="showEditModal"
      :pocket="selectedPocketToEdit"
      @update:show="showEditModal = $event"
      @saved="fetchPockets"
    /> -->
    <DeletePocketModal
      :show="showDeleteModal"
      :pocket="selectedPocketToDelete"
      @update:show="showDeleteModal = $event"
      @deleted="fetchPockets"
    />
  </div>
</template>

<script>
import BaseIconButton from "@/components/Base/BaseIconButton.vue";
import SearchBar from "@/components/SearchBar.vue";
import Pagination from "@/components/Pagination.vue";
import Spinner from "@/components/Spinner.vue";
import AddPocketModal from "@/components/Modal/Pocket/AddPocketModal.vue";
// import EditPocketModal from "@/components/Modal/Pocket/EditPocketModal.vue";
import DeletePocketModal from "@/components/Modal/Pocket/DeletePocketModal.vue";

export default {
  components: {
    BaseIconButton,
    SearchBar,
    Pagination,
    Spinner,
    AddPocketModal,
    DeletePocketModal,
  },
  data() {
    return {
      showAddModal: false,
      showEditModal: false,
      showDeleteModal: false,
      selectedPocketToEdit: null,
      selectedPocketToDelete: null,
      loading: false,
      pockets: [],
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
        list_orders: [{ order_by: "", sort_order: "ASC" }],
        search: [{ s: null, key: null }],
      },
    };
  },

  methods: {
    async fetchPockets() {
      this.loading = true;
      try {
        const res = await this.$axios.post("/v1/pockets/", this.params);

        this.pockets = Array.isArray(res.data.body) ? res.data.body : [];

        this.pagination = {
          current_page: res.data.details?.current_page || 1,
          last_page: res.data.details?.last_page || 1,
          total: res.data.details?.total || 0,
          from: res.data.details?.from || 0,
          to: res.data.details?.to || 0,
        };
      } catch (err) {
        console.error("Failed to fetch pockets:", err);
        this.$notify({
          type: "error",
          title: "Error",
          text: "Failed to load pockets.",
        });
      } finally {
        this.loading = false;
      }
    },

    changePage(page) {
      this.params.page = page;
      this.fetchPockets();
    },

    formatDate(date) {
      return new Date(date).toLocaleDateString();
    },

    openEditModal(pocket) {
      this.selectedPocketToEdit = pocket;
      this.showEditModal = true;
    },

    openDeleteModal(pocket) {
      this.selectedPocketToDelete = pocket;
      this.showDeleteModal = true;
    },
    filePath(path) {
      return `${process.env.VUE_APP_FILE_PATH}${path}`;
    },
  },
  mounted() {
    this.fetchPockets();
  },
};
</script>
