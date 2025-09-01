<template>
  <div class="flex flex-wrap items-center justify-between my-4 gap-2">

    <p class="text-gray-800">
      Showing {{ pagination.from || 0 }}-{{ pagination.to || 0 }} of
      {{ pagination.total || 0 }} results
    </p>

    <div class="flex items-center gap-2">
      <button
        :disabled="pagination.current_page === 1"
        @click="$emit('page-change', pagination.current_page - 1)"
        class="px-3 py-2 bg-gray-200 rounded disabled:opacity-50"
      >
        <i class="ri-arrow-left-s-line"></i>
      </button>

      <button
        v-for="page in pagination.last_page"
        :key="page"
        @click="$emit('page-change', page)"
        class="px-3 py-2 rounded"
        :class="page === pagination.current_page ? 'bg-soft-gray' : 'bg-gray-300'"
      >
        {{ page }}
      </button>

      <button
        :disabled="pagination.current_page >= pagination.last_page"
        @click="$emit('page-change', pagination.current_page + 1)"
        class="px-3 py-2 bg-gray-200 rounded disabled:opacity-50"
      >
        <i class="ri-arrow-right-s-line"></i>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    pagination: {
      type: Object,
      required: true,
    },
  },
};
</script>