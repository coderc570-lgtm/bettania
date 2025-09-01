<template>
    <div class="mx-16 mt-8">
      <div class="flex space-x-4 overflow-x-auto pb-2">
        <button
          v-for="tab in tabs"
          :key="tab"
           @click="$emit('update:activeTab', tab)"
            :class="[
                'px-4 py-2 rounded-full whitespace-nowrap font-medium transition',
                activeTab === tab
                ? 'bg-deep-plum text-white'
                : 'bg-soft-gray text-black hover:bg-l-deep-plum hover:text-white'
            ]"
        >
          {{ tab }}
        </button>
      </div>
    </div>
</template>

<script>
export default {
  name: "TabSlider",
  props: {
    tabs: {
      type: Array,
      required: true
    },
    activeTab: {
      type: String,
      required: true
    }
  }
};
</script>