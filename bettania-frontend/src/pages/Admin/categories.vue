<template>
  <div class="min-h-screen bg-white flex flex-col">
    <BaseHeaderNavigation title="Categories" />

    <div class="mx-16 my-8">
        <div class="my-6 flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap justify-start gap-2">
                <button
                    type="button"
                    @click="showModal = true"
                    class="bg-soft-gray
                    w-40 rounded-xl
                    border border-black
                    px-4 py-2 text-center"
                >
                    <span class="flex items-center justify-center">
                        <i class="ri-add-line"></i>
                        <span class="pr-1">
                            Add Category
                        </span>
                    </span>
                </button>
            </div>
            <div class="relative">
            <input
                type="text"
                placeholder="Search"
                class="rounded-full
                border border-soft-gray
                px-6 py-2 w-72
                focus:outline-none"
            />
            <button
                class="absolute
                right-0 top-0
                h-full px-4
                bg-soft-gray
                rounded-r-full"
            >
                <i class="ri-search-line"></i>
            </button>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
import BaseHeaderNavigation from '@/components/Base/BaseHeaderNavigation.vue';

export default {
  components: {
    BaseHeaderNavigation,
 },
}
</script>