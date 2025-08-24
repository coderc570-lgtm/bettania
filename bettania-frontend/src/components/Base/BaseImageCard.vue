<template>
    <div
      class="flex flex-col items-center bg-white shadow-md rounded-lg h-48 w-40 p-4 border border-solid hover:bg-gray-100 transition duration-300 ease-in-out"
      :class="[selected ? 'border-2 border-blue-400' : 'border-gray-300']"
      @click="$emit('select')"
    >
      <img
        :src="imageSrc"
        alt="Image Card"
        class="object-cover rounded-lg h-32 w-full"
        :class="props.customImgClass"
      />
      <div class="text-center mt-2">
        <p class="text-gray-600">{{ title }}</p>
      </div>
    </div>
  </template>
  
  <script setup lang="ts">
  const props = defineProps<{
    imageSrc: string,
    title: string,
    selected?: boolean
    customImgClass?: string
  }>()
  
  defineEmits<{
    (e: 'select'): void
  }>()
  </script>
  