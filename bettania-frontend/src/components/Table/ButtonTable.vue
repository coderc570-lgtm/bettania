<template>
  <div class="mx-16 mb-4">
    <div class="my-6 flex flex-wrap items-center justify-between gap-4">
      <BaseIconButton
        label="Add Button"
        icon="ri-add-line"
        variant="default"
        aos="fade-up"
        @click="showAddModal = true"
      />
      <SearchBar
        v-model="params.search_global"
        @search="fetchButton"
      />
    </div>

    <Pagination
      :pagination="pagination"
      @page-change="changePage"
    />

    <Spinner
      v-if="loading"
      class="col-span-full"
      label="Loading Buttons..."
    />

    <div
      v-if="!loading && buttons.length"
      class="grid grid-cols-1
      sm:grid-cols-2
      md:grid-cols-3
      lg:grid-cols-4
      gap-6"
    >
      <div
        v-for="(button, index) in buttons"
        :key="button.buttons_id || index"
        class="bg-white border
        rounded-lg shadow
        hover:shadow-lg
        transition
        overflow-hidden"
        data-aos="fade-up"
        :data-aos-delay="index * 100"
      >
        <img
          v-if="button.buttons_filepath"
          :src="filePath(button.buttons_filepath)"
          alt="Button Image"
          class="w-full h-40 object-cover"
        />
        <div class="p-4">
          <h3 class="font-bold text-lg mb-2">
            {{ button.buttons_name }}
          </h3>
          <p class="text-gray-600"><span class="font-semibold">
            Price:</span> {{ button.buttons_price ? '$' + button.buttons_price : 'N/A' }}
          </p>
        </div>

        <div class="p-4 flex justify-end gap-2">
          <button @click="openEditModal(button)">
            <i class="ri-edit-2-line hover:text-deep-plum"></i>
          </button>
          <button @click="openDeleteModal(button)">
            <i class="ri-delete-bin-line hover:text-red-500"></i>
          </button>
        </div>
      </div>
    </div>

    <p
      v-if="!loading && !buttons.length"
      class="text-center text-gray-500 mt-10"
    >
      No buttons found.
    </p>

    <!-- Add Modal -->
    <AddButtonModal
      :show="showAddModal"
      @update:show="showAddModal = $event"
      @saved="fetchButton"
    />

    <!-- Edit Modal -->
    <EditButtonModal
      :show="showEditModal"
      :button="selectedButtonToEdit"
      @update:show="showEditModal = $event"
      @updated="fetchButton"
    />

    <!-- Delete Modal -->
    <DeleteButtonModal
      :show="showDeleteModal"
      :button="selectedButtonToDelete"
      @update:show="showDeleteModal = $event"
      @deleted="fetchButton"
    />
  </div>
</template>

<script>
import BaseIconButton from "@/components/Base/BaseIconButton.vue";
import SearchBar from "@/components/SearchBar.vue";
import Pagination from "@/components/Pagination.vue";
import Spinner from "@/components/Spinner.vue";
import AddButtonModal from "@/components/Modal/Button/AddButtonModal.vue";
import EditButtonModal from "@/components/Modal/Button/EditButtonModal.vue";
import DeleteButtonModal from "@/components/Modal/Button/DeleteButtonModal.vue";

export default {
  components: {
    BaseIconButton,
    SearchBar,
    Pagination,
    Spinner,
    AddButtonModal,
    EditButtonModal,
    DeleteButtonModal,
  },
  data() {
    return {
      showAddModal: false,
      showEditModal: false,
      showDeleteModal: false,
      selectedButtonToEdit: null,
      selectedButtonToDelete: null,
      loading: false,
      buttons: [],
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
    async fetchButton() {
      this.loading = true;
      try {
        const res = await this.$axios.post("/v1/buttons", this.params);

        this.buttons = Array.isArray(res.data.body) ? res.data.body : [];

        this.pagination = {
          current_page: res.data.details?.current_page || 1,
          last_page: res.data.details?.last_page || 1,
          total: res.data.details?.total || 0,
          from: res.data.details?.from || 0,
          to: res.data.details?.to || 0,
        };
      } catch (err) {
        console.error("Failed to fetch buttons:", err);
        this.$notify({
          type: "error",
          title: "Error",
          text: "Failed to load buttons.",
        });
      } finally {
        this.loading = false;
      }
    },
    changePage(page) {
      this.params.page = page;
      this.fetchButton();
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString();
    },
    openEditModal(button) {
      this.selectedButtonToEdit = button;
      this.showEditModal = true;
    },
    openDeleteModal(button) {
      this.selectedButtonToDelete = button;
      this.showDeleteModal = true;
    },
    filePath(path) {
      return `${process.env.VUE_APP_FILE_PATH}${path}`;
    },
  },
  mounted() {
    this.fetchButton();
  },
};
</script>
