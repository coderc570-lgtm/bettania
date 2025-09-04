<template>
  <div class="mx-16 mb-4">
    <div class="my-6 flex flex-wrap items-center justify-between gap-4">
      <BaseIconButton
        label="Add Trouser"
        icon="ri-add-line"
        variant="default"
        aos="fade-up"
        @click="showAddModal = true"
      />
      <SearchBar
        v-model="params.search_global"
        @search="fetchTrouser"
      />
    </div>

    <Pagination
      :pagination="pagination"
      @page-change="changePage"
    />

    <Spinner
      v-if="loading"
      class="col-span-full"
      label="Loading Trousers..."
    />

    <div
      v-if="!loading && trousers.length"
      class="grid grid-cols-1
      sm:grid-cols-2
      md:grid-cols-3
      lg:grid-cols-4
      gap-6"
    >
      <div
        v-for="(trouser, index) in trousers"
        :key="trouser.trouser_fabrics_id || index"
        class="bg-white border
        rounded-lg shadow
        hover:shadow-lg
        transition
        overflow-hidden"
        data-aos="fade-up"
        :data-aos-delay="index * 100"
      >
        <img
          v-if="trouser.trouser_fabrics_filepath"
          :src="filePath(trouser.trouser_fabrics_filepath)"
          alt="Trouser Image"
          class="w-full h-40 object-cover"
        />
        <div class="p-4">
          <h3 class="font-bold text-lg mb-2">
            {{ trouser.trouser_fabrics_name }}
          </h3>
          <p class="text-gray-600"><span class="font-semibold">
            Price:</span> {{ trouser.trouser_fabrics_price ? '$' + trouser.trouser_fabrics_price : 'N/A' }}
          </p>
        </div>

        <div class="p-4 flex justify-end gap-2">
          <button @click="openEditModal(trouser)">
            <i class="ri-edit-2-line hover:text-deep-plum"></i>
          </button>
          <button @click="openDeleteModal(trouser)">
            <i class="ri-delete-bin-line hover:text-red-500"></i>
          </button>
        </div>
      </div>
    </div>

    <p
      v-if="!loading && !trousers.length"
      class="bg-gray-200 col-span-full text-center text-black py-8"
      data-aos="fade-up"
      data-aos-delay="100"
      data-aos-duration="600"
    >
      No trousers found.
    </p>

    <!-- Add Modal -->
    <AddTrouserModal
      :show="showAddModal"
      @update:show="showAddModal = $event"
      @saved="fetchTrouser"
    />

    <!-- Edit Modal -->
    <EditTrouserModal
      :show="showEditModal"
      :trouser="selectedTrouserToEdit"
      @update:show="showEditModal = $event"
      @updated="fetchTrouser"
    />

    <!-- Delete Modal -->
    <DeleteTrouserModal
      :show="showDeleteModal"
      :trouser="selectedTrouserToDelete"
      @update:show="showDeleteModal = $event"
      @deleted="fetchTrouser"
    />
  </div>
</template>

<script>
import BaseIconButton from "@/components/Base/BaseIconButton.vue";
import SearchBar from "@/components/SearchBar.vue";
import Pagination from "@/components/Pagination.vue";
import Spinner from "@/components/Spinner.vue";
import AddTrouserModal from "@/components/Modal/Trouser/AddTrouserModal.vue";
import EditTrouserModal from "@/components/Modal/Trouser/EditTrouserModal.vue";
import DeleteTrouserModal from "@/components/Modal/Trouser/DeleteTrouserModal.vue";

export default {
  components: {
    BaseIconButton,
    SearchBar,
    Pagination,
    Spinner,
    AddTrouserModal,
    EditTrouserModal,
    DeleteTrouserModal,
  },
  data() {
    return {
      showAddModal: false,
      showEditModal: false,
      showDeleteModal: false,
      selectedTrouserToEdit: null,
      selectedTrouserToDelete: null,
      loading: false,
      trousers: [],
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
    async fetchTrouser() {
      this.loading = true;
      try {
        const res = await this.$axios.post("/v1/trouser-fabrics", this.params);

        this.trousers = Array.isArray(res.data.body) ? res.data.body : [];

        this.pagination = {
          current_page: res.data.details?.current_page || 1,
          last_page: res.data.details?.last_page || 1,
          total: res.data.details?.total || 0,
          from: res.data.details?.from || 0,
          to: res.data.details?.to || 0,
        };
      } catch (err) {
        console.error("Failed to fetch trousers:", err);
        this.$notify({
          type: "error",
          title: "Error",
          text: "Failed to load trousers.",
        });
      } finally {
        this.loading = false;
      }
    },
    changePage(page) {
      this.params.page = page;
      this.fetchTrouser();
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString();
    },
    openEditModal(trouser) {
      this.selectedTrouserToEdit = trouser;
      this.showEditModal = true;
    },
    openDeleteModal(trouser) {
      this.selectedTrouserToDelete = trouser;
      this.showDeleteModal = true;
    },
    filePath(path) {
      return `${process.env.VUE_APP_FILE_PATH}${path}`;
    },
  },
  mounted() {
    this.fetchTrouser();
  },
};
</script>
