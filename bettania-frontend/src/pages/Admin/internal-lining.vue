<template>
  <div class="min-h-screen bg-white flex flex-col">
    <BaseHeaderNavigation title="Internal Lining" />
    <InternalLining class="py-8"/>
  </div>
</template>

<script>
import BaseHeaderNavigation from "@/components/Base/BaseHeaderNavigation.vue";
import InternalLining from "@/components/Table/InternalLiningTable.vue";

export default {
  components: {
    InternalLining,
    BaseHeaderNavigation,
  },
};
</script>