<template>
  <div class="mx-16 mb-4">
    <div class="my-6 flex flex-wrap items-center justify-between gap-4">
      <BaseIconButton
        label="Add Lapel"
        icon="ri-add-line"
        variant="default"
        aos="fade-up"
        @click="showAddModal = true"
      />
      <SearchBar
        v-model="params.search_global"
        @search="fetchLapel"
      />
    </div>

    <Pagination
      :pagination="pagination"
      @page-change="changePage"
    />

    <Spinner
      v-if="loading"
      class="col-span-full"
      label="Loading Lapels..."
    />

    <div
      v-if="!loading && lapels.length"
      class="grid grid-cols-1
      sm:grid-cols-2
      md:grid-cols-3
      lg:grid-cols-4
      gap-6"
    >
      <div
        v-for="(lapel, index) in lapels"
        :key="lapel.lapels_id || index"
        class="bg-white border
        rounded-lg shadow
        hover:shadow-lg
        transition
        overflow-hidden"
        data-aos="fade-up"
        :data-aos-delay="index * 100"
      >
        <img
          v-if="lapel.lapels_filepath"
          :src="filePath(lapel.lapels_filepath)"
          alt="Lapel Image"
          class="w-full h-40 object-cover"
        />
        <div class="p-4">
          <h3 class="font-bold text-lg mb-2">
            {{ lapel.lapels_name }}
          </h3>
          <p class="text-gray-600 mb-1"><span class="font-semibold">
            Description:</span> {{ lapel.lapels_description || 'N/A' }}
          </p>
          <p class="text-gray-600"><span class="font-semibold">
            Price:</span> {{ lapel.lapels_price ? '$' + lapel.lapels_price : 'N/A' }}
          </p>
        </div>

        <div class="p-4 flex justify-end gap-2">
          <button @click="openEditModal(lapel)">
            <i class="ri-edit-2-line hover:text-deep-plum"></i>
          </button>
          <button @click="openDeleteModal(lapel)">
            <i class="ri-delete-bin-line hover:text-red-500"></i>
          </button>
        </div>
      </div>
    </div>

    <p
      v-if="!loading && !lapels.length"
      class="bg-gray-200 col-span-full text-center text-black py-8"
      data-aos="fade-up"
      data-aos-delay="100"
      data-aos-duration="600"
    >
      No lapels found.
    </p>

    <!-- Add Modal -->
    <AddLapelModal
      :show="showAddModal"
      @update:show="showAddModal = $event"
      @saved="fetchLapel"
    />

    <!-- Edit Modal -->
    <EditLapelModal
      :show="showEditModal"
      :lapel="selectedLapelToEdit"
      @update:show="showEditModal = $event"
      @updated="fetchLapel"
    />

    <!-- Delete Modal -->
    <DeleteLapelModal
      :show="showDeleteModal"
      :lapel="selectedLapelToDelete"
      @update:show="showDeleteModal = $event"
      @deleted="fetchLapel"
    />
  </div>
</template>

<script>
import BaseIconButton from "@/components/Base/BaseIconButton.vue";
import SearchBar from "@/components/SearchBar.vue";
import Pagination from "@/components/Pagination.vue";
import Spinner from "@/components/Spinner.vue";
import AddLapelModal from "@/components/Modal/Lapel/AddLapelModal.vue";
import EditLapelModal from "@/components/Modal/Lapel/EditLapelModal.vue";
import DeleteLapelModal from "@/components/Modal/Lapel/DeleteLapelModal.vue";

export default {
  components: {
    BaseIconButton,
    SearchBar,
    Pagination,
    Spinner,
    AddLapelModal,
    EditLapelModal,
    DeleteLapelModal,
  },
  data() {
    return {
      showAddModal: false,
      showEditModal: false,
      showDeleteModal: false,
      selectedLapelToEdit: null,
      selectedLapelToDelete: null,
      loading: false,
      lapels: [],
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
    async fetchLapel() {
      this.loading = true;
      try {
        const res = await this.$axios.post("/v1/lapels", this.params);

        this.lapels = Array.isArray(res.data.body) ? res.data.body : [];

        this.pagination = {
          current_page: res.data.details?.current_page || 1,
          last_page: res.data.details?.last_page || 1,
          total: res.data.details?.total || 0,
          from: res.data.details?.from || 0,
          to: res.data.details?.to || 0,
        };
      } catch (err) {
        console.error("Failed to fetch lapels:", err);
        this.$notify({
          type: "error",
          title: "Error",
          text: "Failed to load lapels.",
        });
      } finally {
        this.loading = false;
      }
    },
    changePage(page) {
      this.params.page = page;
      this.fetchLapel();
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString();
    },
    openEditModal(lapel) {
      this.selectedLapelToEdit = lapel;
      this.showEditModal = true;
    },
    openDeleteModal(lapel) {
      this.selectedLapelToDelete = lapel;
      this.showDeleteModal = true;
    },
    filePath(path) {
      return `${process.env.VUE_APP_FILE_PATH}${path}`;
    },
  },
  mounted() {
    this.fetchLapel();
  },
};
</script>
