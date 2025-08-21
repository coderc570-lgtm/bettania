<template>
    <label class="inline-flex items-center me-5 cursor-pointer">
      <input 
        type="checkbox" 
        class="sr-only peer" 
        :checked="modelValue" 
        @change="handleClick"
      >
      <div
        class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full
        peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300
        after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600">
      </div>
    </label>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
name: 'BaseToggle',
props: {
    label: {
    type: String,
    default: 'Button',
    },
    modelValue: { // Use v-model to handle the checked state
    type: Boolean,
    default: false,
    },
    customClass: {
    type: String,
    default: '',
    },
  },
  emits: ['update:modelValue'], // Emit the update for v-model binding
  methods: {
      handleClick(event: Event) {
      const target = event.target as HTMLInputElement;
      this.$emit('update:modelValue', target.checked); // Emit the new value
      },
  },
});
</script>
  