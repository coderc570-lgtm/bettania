<template>
  <div>
    <label :for="id" class="block text-sm font-medium text-gray-700">
      {{ label }}
    </label>
    <textarea
      :id="id"
      :name="name"
      :placeholder="placeholder"
      :rows="rows"
      v-model="modelValue"
      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring-black focus:border-black"
    ></textarea>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  id: string
  name: string
  label: string
  placeholder?: string
  rows?: number
  modelValue: string
}>()

defineEmits(['update:modelValue'])
</script>
