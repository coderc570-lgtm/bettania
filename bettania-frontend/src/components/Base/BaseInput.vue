<template>
  <div>
    <label :for="name" class="block mb-2 text-sm font-medium text-gray-900">{{ label }}</label>
    <input
      :type="type"
      :name="name"
      :id="name"
      :class="`bg-gray-50 border border-gray-300 rounded-md mb-2 focus:outline-none focus:ring-2 focus:ring-primary-500 block p-1.5 ${customClass}`"
      :placeholder="placeholder"
      v-model="internalValue"
      required
    />
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'BaseInput',
  props: {
    modelValue: {
      type: String,
      default: ''
    },
    type: {
      type: String,
      default: 'text'
    },
    name: {
      type: String,
      required: true
    },
    label: {
      type: String,
      required: true
    },
    placeholder: {
      type: String,
      default: ''
    },
    customClass: {
      type: String,
      default: ''
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
