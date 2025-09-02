<template>
  <div class="mx-16 mb-4">
    <div class="my-6 flex flex-wrap items-center justify-between gap-4">
      <BaseIconButton
        label="Add Mill"
        icon="ri-add-line"
        variant="default"
        aos="fade-up"
        @click="showAddModal = true"
      />
      <SearchBar
        v-model="params.search_global"
        @search="fetchMills"
      />
    </div>

    <Pagination
      :pagination="pagination"
      @page-change="changePage"
    />

    <Spinner
      v-if="loading"
      class="col-span-full"
      label="Loading Fabric Mills..."
    />

    <div
      v-else-if="mills.length === 0"
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
        No Fabric Mill Found
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
        v-for="(mill, index) in mills"
        :key="mill.fabric_mills_id"
        class="p-4 bg-white
        rounded-xl shadow
        hover:shadow-lg
        transition relative"
        data-aos="fade-up"
        :data-aos-delay="index * 100"
      >
        <h3 class="text-lg font-semibold text-gray-800">
          {{ mill.fabric_mills_title }}
        </h3>

        <p class="text-sm text-gray-600 mt-1">
          Created: {{ formatDate(mill.fabric_mills_created_at) }}
        </p>

        <div class="absolute top-3 right-3 flex space-x-2">
          <button @click="openEditModal(mill)">
            <i class="ri-edit-2-line hover:text-deep-plum"></i>
          </button>
          <button @click="openDeleteModal(mill)">
            <i class="ri-delete-bin-line hover:text-red-500"></i>
          </button>
        </div>
      </div>
    </div>

    <AddMillModal
      :show="showAddModal"
      @update:show="showAddModal = $event"
      @saved="fetchMills"
    />
    <EditMillModal
      :show="showEditModal"
      :mill="selectedMillToEdit"
      @update:show="showEditModal = $event"
      @updated="fetchMills"
    />
    <DeleteMillModal
      :show="showDeleteModal"
      :mill="selectedMillToDelete"
      @update:show="showDeleteModal = $event"
      @deleted="fetchMills"
    />
  </div>
</template>

<script>
import BaseIconButton from "@/components/Base/BaseIconButton.vue";
import SearchBar from "@/components/SearchBar.vue";
import Pagination from "@/components/Pagination.vue";
import Spinner from "@/components/Spinner.vue";
import AddMillModal from "@/components/Modal/Fabric/AddMillModal.vue";
import EditMillModal from "@/components/Modal/Fabric/EditMillModal.vue";
import DeleteMillModal from "@/components/Modal/Fabric/DeleteMillModal.vue";

export default {
  components: {
    BaseIconButton,
    SearchBar,
    Pagination,
    Spinner,
    AddMillModal,
    EditMillModal,
    DeleteMillModal
  },
  data() {
    return {
      showAddModal: false,
      showEditModal: false,
      showDeleteModal: false,
      selectedMillToEdit: null,
      selectedMillToDelete: null,
      loading: false,
      mills: [],
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
            order_by: "fabric_mills_title",
            sort_order: "ASC",
          },
        ],
      },
    };
  },

  methods: {
    async fetchMills() {
      this.loading = true;
      try {
        const res = await this.$axios.post("/v1/fabric-mills", this.params);

        this.mills = Array.isArray(res.data.body) ? res.data.body : [];

        this.pagination = {
          current_page: res.data.details?.current_page || 1,
          last_page: res.data.details?.last_page || 1,
          total: res.data.details?.total || 0,
          from: res.data.details?.from || 0,
          to: res.data.details?.to || 0,
        };
      } catch (err) {
        console.error("Failed to fetch mills:", err);
        this.$notify({
          type: "error",
          title: "Error",
          text: "Failed to load Mills.",
        });
      } finally {
        this.loading = false;
      }
    },
    changePage(page) {
      this.params.page = page;
      this.fetchMills();
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString();
    },
    updateMill(mill) {
      this.$notify({
        type: "info",
        title: "Update",
        text: `Update action for: ${mill.fabric_mills_title}`,
      });
    },
    async deleteMill(id) {
      if (!confirm("Are you sure you want to delete this mill?")) return;

      try {
        await this.$axios.delete(`/v1/fabric-mills/${id}`);
        this.$notify({
          type: "success",
          title: "Deleted",
          text: "Mill deleted successfully.",
        });
        this.fetchMills();
      } catch (err) {
        console.error("Delete failed:", err);
        this.$notify({
          type: "error",
          title: "Error",
          text: "Failed to delete Mill.",
        });
      }
    },
    openEditModal(mill) {
      this.selectedMillToEdit = mill;
      this.showEditModal = true;
    },
    openDeleteModal(mill) {
      this.selectedMillToDelete = mill;
      this.showDeleteModal = true;
    },
  },
  mounted() {
    this.fetchMills();
  },
};
</script>