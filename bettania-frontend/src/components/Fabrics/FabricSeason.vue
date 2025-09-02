<template>
  <div class="mx-16 mb-4">
    <div class="my-6 flex flex-wrap items-center justify-between gap-4">
      <BaseIconButton
        label="Add Season"
        icon="ri-add-line"
        variant="default"
        aos="fade-up"
        @click="showAddModal = true"
      />
      <SearchBar
        v-model="params.search_global"
        @search="fetchSeasons"
      />
    </div>

    <Pagination
      :pagination="pagination"
      @page-change="changePage"
    />

    <Spinner
      v-if="loading"
      class="col-span-full"
      label="Loading Season..."
    />
    
    <BaseGrid
      v-else
      :items="formattedSeason"
      label="Season"
      @edit="editSeason"
      @delete="deleteSeason"
    />

    <AddSeasonModal
      :show="showAddModal"
      @update:show="val => showAddModal = val"
      @saved="fetchSeasons"
    />
    <EditSeasoncModal
      :show="showEditModal"
      :season="selectedSeason"
      @update:show="val => showEditModal = val"
      @saved="fetchSeasons"
    />
    <DeleteSeasonModal
      :show="showDeleteModal"
      :season="selectedSeasonToDelete"
      @update:show="val => showDeleteModal = val"
      @deleted="fetchSeasons"
    />
  </div>
</template>

<script>
import Spinner from "@/components/Spinner.vue";
import SearchBar from "@/components/SearchBar.vue";
import Pagination from "@/components/Pagination.vue";
import BaseIconButton from "@/components/Base/BaseIconButton.vue";
import BaseGrid from "@/components/Base/BaseGrid.vue";
import AddSeasonModal from "@/components/Modal/Fabric/AddSeasonModal.vue";
import EditSeasoncModal from "@/components/Modal/Fabric/EditSeasonModal.vue";
import DeleteSeasonModal from "@/components/Modal/Fabric/DeleteSeasonModal.vue";

export default {
  components: {
    Spinner,
    SearchBar,
    Pagination,
    BaseIconButton,
    BaseGrid,
    AddSeasonModal,
    EditSeasoncModal,
    DeleteSeasonModal
  },
  data() {
    return {
      seasons: [],
      loading: false,
      showAddModal: false,
      showEditModal: false,
      showDeleteModal: false,
      selectedSeason: null,
      selectedSeasonToDelete: null,
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
            order_by: "fabric_seasons.title",
            sort_order: "ASC"
          }
        ]
      },
    };
  },
  computed: {
    formattedSeason() {
      return this.seasons.map(f => ({
        id: f.fabric_seasons_id,
        image: f.fabric_seasons_filepath,
        title: f.fabric_seasons_title,
        subtitle: `Created: ${new Date(f.fabric_seasons_created_at).toLocaleDateString()}`
      }));
    },
  },
  methods: {
    async fetchSeasons() {
      this.loading = true;
      try {
        const res = await this.$axios.post("/v1/fabric-seasons", this.params);
        this.seasons = res.data.body || [];
        this.pagination = res.data.details || { current_page: 1, last_page: 1, total: 0, from: 0, to: 0 };
      } catch (err) {
        console.error(err);
      } finally {
        this.loading = false;
      }
    },
    editSeason(season) {
      this.selectedSeason = season;
      this.showEditModal = true;
    },
    deleteSeason(season) {
      this.selectedSeasonToDelete = season;
      this.showDeleteModal = true;
    },
    changePage(page) {
      this.params.page = page;
      this.fetchSeasons();
    },
  },
  mounted() { this.fetchSeasons(); },
};
</script>