<template>
  <class class="min-h-screen bg-white flex flex-col">
    <BaseHeaderNavigation title="Fabrics"/>
    <div class="mx-16 my-8">
        <div class="my-6 flex flex-wrap items-center justify-between gap-4">
            <div class="flex gap-4">
              <div class="flex flex-wrap justify-start gap-2">
                <button
                    type="button"
                    @click="showModal = true"
                    class="bg-soft-gray
                    w-auto rounded-xl
                    border border-black
                    px-4 py-2 text-center"
                >
                    <span class="flex items-center justify-center">
                        <i class="ri-add-line"></i>
                        <span class="pr-1">
                            Add Fabric Design
                        </span>
                    </span>
                </button>
              </div>
            </div>
        </div>
        <AddFabricModal
            :show="showModal"
        />
    </div>
  </class>
</template>
            
<script>
import BaseHeaderNavigation from '@/components/Base/BaseHeaderNavigation.vue';
import AddFabricModal from '@/components/Modal/AddFabricModal.vue';


export default {
  components: {
    BaseHeaderNavigation,
    AddFabricModal,
 },
  data() {
    return {
      showModal: false,
    }
  }
}
</script>