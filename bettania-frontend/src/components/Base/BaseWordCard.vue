<template>
    <div>
        <div
            class="flex flex-col items-center justify-center bg-white shadow-md rounded-lg h-15 w-40 p-4 border-solid border hover:bg-gray-100 transition duration-300 ease-in-out"
            :class="[selected ? 'border-2 border-blue-400' : 'border-gray-300']"
            @click="$emit('select')"
        >
            <div class="text-center">
                <p class="text-gray-600">{{ title }}</p>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
defineProps<{
  title: string,
  selected?: boolean
}>()

defineEmits<{
  (e: 'select'): void
}>()
</script>