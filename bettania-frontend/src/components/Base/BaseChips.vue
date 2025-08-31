<template>
    <!-- <div> -->
        <button 
            type="button"
            class="bg-gray-100 px-4 py-2 rounded-full text-gray-700 hover:bg-gray-200 
                    focus:outline-none focus:ring-1 focus:ring-gray-300 
                    transition duration-300 ease-in-out 
                    truncate max-w-full"
            @click="$emit('click')"
            >
            {{ title }}
        </button>
    <!-- </div> -->
</template>

<script setup lang="ts">
 const props = defineProps<{
    // imageSrc: string,
    title: string,
    // selected?: boolean
    // customImgClass?: string
  }>()
  
  defineEmits<{
    (e: 'click'): void
  }>()
</script>