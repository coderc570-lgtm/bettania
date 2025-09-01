<template>
  <div class="mx-16 mb-4">
    <div class="my-6 flex flex-wrap items-center justify-between gap-4">
      <BaseIconButton
        label="Add Fabric Mill"
        icon="ri-add-line"
        variant="default"
        aos="fade-up"
        @click="showAddModal = true"
      />
      <SearchBar/>
    </div>

    <div class="mt-8 mb-8 flex flex-wrap items-center justify-between">
      <p class="text-gray-800">
        Showing 0 of 0 results
      </p>

      <div class="flex items-center gap-2">
        <button class="px-3 py-2 bg-gray-200 rounded disabled:opacity-50">
          <i class="ri-arrow-left-s-line"></i>
        </button>

        <button
          class="px-3 py-2 rounded bg-soft-gray"
        >
          1
        </button>

        <button class="px-3 py-2 bg-gray-200 rounded disabled:opacity-50">
          <i class="ri-arrow-right-s-line"></i>
        </button>
      </div>
    </div>

    <div
      class="bg-gray-200 col-span-full text-center text-black py-8"
      data-aos="fade-up"
      data-aos-delay="100"
      data-aos-duration="600"
    >
      <p>
        No Fabric Mill Found
      </p>
    </div>
  </div>
</template>

<script>
import BaseIconButton from "@/components/Base/BaseIconButton.vue";
import SearchBar from "@/components/SearchBar.vue";

export default {
  components: {
    BaseIconButton,
    SearchBar
  },
  data() {
    return {
      showAddModal: false,
    }
  }
}
</script>