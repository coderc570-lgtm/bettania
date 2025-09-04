<template>
  <div class="min-h-screen bg-white flex flex-col">
    <BaseHeaderNavigation title="Custom Made" />
    <CustomMade class="py-8"/>
  </div>
</template>

<script>
import BaseHeaderNavigation from "@/components/Base/BaseHeaderNavigation.vue";
import CustomMade from "@/components/Table/CustomMadeTable.vue";

export default {
  components: {
    CustomMade,
    BaseHeaderNavigation,
  },
};
</script>