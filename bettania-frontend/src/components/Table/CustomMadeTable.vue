<template>
  <div class="mx-16 mb-4">
    <div class="my-6 flex flex-wrap items-center justify-between gap-4">
      <BaseIconButton
        label="Add Custom Made"
        icon="ri-add-line"
        variant="default"
        aos="fade-up"
        @click="showAddModal = true"
      />
      <SearchBar
        v-model="params.search_global"
        @search="fetchCustomMade"
      />
    </div>

    <Pagination
      :pagination="pagination"
      @page-change="changePage"
    />

    <Spinner
      v-if="loading"
      class="col-span-full"
      label="Loading Custom Made..."
    />

    <div
      v-else-if="custom.length === 0"
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
        No Custom MAde Found
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
        v-for="(custom, index) in custom"
        :key="custom.custom_mades_id"
        class="p-4 bg-white
        rounded-xl shadow
        hover:shadow-lg
        transition relative"
        data-aos="fade-up"
        :data-aos-delay="index * 100"
      >
        <h3 class="text-lg font-semibold text-gray-800">
          {{ custom.custom_mades_title }}
        </h3>

        <p class="text-sm text-gray-600 mt-1">
          Created: {{ formatDate(custom.custom_mades_created_at) }}
        </p>

        <div class="absolute top-3 right-3 flex space-x-2">
          <button @click="openEditModal(custom)">
            <i class="ri-edit-2-line hover:text-deep-plum"></i>
          </button>
          <button @click="openDeleteModal(custom)">
            <i class="ri-delete-bin-line hover:text-red-500"></i>
          </button>
        </div>
      </div>
    </div>

    <AddCustomMadeModal
      :show="showAddModal"
      @update:show="showAddModal = $event"
      @saved="fetchCustomMade"
    />
    <EditCustomMadeModal
      :show="showEditModal"
      :custom="selectedCustomMadeToEdit"
      @update:show="showEditModal = $event"
      @updated="fetchCustomMade"
    />
    <DeleteCustomMadeModal
      :show="showDeleteModal"
      :custom="selectedCustomMadeToDelete"
      @update:show="showDeleteModal = $event"
      @deleted="fetchCustomMade"
    />
  </div>
</template>

<script>
import BaseIconButton from "@/components/Base/BaseIconButton.vue";
import SearchBar from "@/components/SearchBar.vue";
import Pagination from "@/components/Pagination.vue";
import Spinner from "@/components/Spinner.vue";
import AddCustomMadeModal from "@/components/Modal/CustomMade/AddCustomMadeModal.vue";
import EditCustomMadeModal from "@/components/Modal/CustomMade/EditCustomMadeModal.vue";
import DeleteCustomMadeModal from "@/components/Modal/CustomMade/DeleteCustomMadeModal.vue";

export default {
  components: {
    BaseIconButton,
    SearchBar,
    Pagination,
    Spinner,
    AddCustomMadeModal,
    EditCustomMadeModal,
    DeleteCustomMadeModal
  },
  data() {
    return {
      showAddModal: false,
      showEditModal: false,
      showDeleteModal: false,
      selectedCustomMadeToEdit: null,
      selectedCustomMadeToDelete: null,
      loading: false,
      custom: [],
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
    async fetchCustomMade() {
      this.loading = true;
      try {
        const res = await this.$axios.post("/v1/custom-mades", this.params);

        this.custom = Array.isArray(res.data.body) ? res.data.body : [];

        this.pagination = {
          current_page: res.data.details?.current_page || 1,
          last_page: res.data.details?.last_page || 1,
          total: res.data.details?.total || 0,
          from: res.data.details?.from || 0,
          to: res.data.details?.to || 0,
        };
      } catch (err) {
        console.error("Failed to fetch custom made:", err);
        this.$notify({
          type: "error",
          title: "Error",
          text: "Failed to load custom made.",
        });
      } finally {
        this.loading = false;
      }
    },
    changePage(page) {
      this.params.page = page;
      this.fetchCustomMade();
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString();
    },
    updateCustom(custom) {
      this.$notify({
        type: "info",
        title: "Update",
        text: `Update action for: ${custom.custom_title}`,
      });
    },
    openEditModal(custom) {
      this.selectedCustomMadeToEdit = custom;
      this.showEditModal = true;
    },
    openDeleteModal(custom) {
      this.selectedCustomMadeToDelete = custom;
      this.showDeleteModal = true;
    },
  },
  mounted() {
    this.fetchCustomMade();
  },
};
</script>