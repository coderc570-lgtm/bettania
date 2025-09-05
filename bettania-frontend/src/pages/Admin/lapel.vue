<template>
  <div class="min-h-screen bg-white flex flex-col">
    <BaseHeaderNavigation title="Lapel" />
    <Lapel class="py-8"/>
  </div>
</template>

<script>
import BaseHeaderNavigation from "@/components/Base/BaseHeaderNavigation.vue";
import Lapel from "@/components/Table/LapelTable.vue";

export default {
  components: {
    Lapel,
    BaseHeaderNavigation,
  },
};
</script>