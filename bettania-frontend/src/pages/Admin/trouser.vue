<template>
  <div class="min-h-screen bg-white flex flex-col">
    <BaseHeaderNavigation title="Trouser" />
    <Trouser class="py-8"/>
  </div>
</template>

<script>
import BaseHeaderNavigation from "@/components/Base/BaseHeaderNavigation.vue";
import Trouser from "@/components/Table/TrouserTable.vue";

export default {
  components: {
    Trouser,
    BaseHeaderNavigation,
  },
};
</script>