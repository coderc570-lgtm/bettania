<template>
  <div>
    <label :for="name" class="block mb-2 text-sm font-medium text-gray-900">{{ label }}</label>
    <select
      :name="name"
      :id="name"
      v-model="internalValue"
      :class="`bg-gray-50 border border-gray-300 rounded-md mb-2 focus:outline-none focus:ring-2 focus:ring-primary-500 block p-1.5 ${customClass}`"
    >
      <option v-for="option in options" :key="option.value" :value="option.value">
        {{ option.text }}
      </option>
    </select>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'BaseSelect',
  props: {
    name: {
      type: String,
      required: true
    },
    label: {
      type: String,
      required: true
    },
    options: {
      type: Array as () => { text: string; value: string | number }[],
      required: true
    },
    customClass: {
      type: String,
      default: ''
    },
    modelValue: {
      type: String,
      required: true
    },
  },
  data() {
    return {
      internalValue: this.modelValue, // Initialize internal value with modelValue
    };
  },
  watch: {
    // Watch for changes in internalValue to emit updates
    internalValue(newValue) {
      this.$emit('update:modelValue', newValue);
    },
    // Watch for changes in modelValue and update internalValue
    modelValue(newValue) {
      this.internalValue = newValue;
    },
  },
});
</script>
