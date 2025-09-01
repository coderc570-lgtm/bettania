<template>
  <div class="relative w-full max-w-xs">
    <input
      v-model="searchValue"
      type="text"
      placeholder="Search"
      class="rounded-full
      border border-soft-gray
      px-6 py-2 w-full
      focus:outline-none"
      @input="onSearch"
    />
  </div>
</template>

<script>
export default {
  props: {
    modelValue: String,
  },
  data() {
    return {
      searchValue: this.modelValue || '',
    };
  },
  watch: {
    modelValue(val) {
      this.searchValue = val;
    },
  },
  methods: {
    onSearch() {
      this.$emit('update:modelValue', this.searchValue);
      this.$emit('search', this.searchValue);
    },
  },
};
</script>