<template>
  <div class="min-h-screen bg-white flex flex-col">
    <BaseHeaderNavigation title="Button" />
    <Button class="py-8"/>
  </div>
</template>

<script>
import BaseHeaderNavigation from "@/components/Base/BaseHeaderNavigation.vue";
import Button from "@/components/Table/ButtonTable.vue";

export default {
  components: {
    Button,
    BaseHeaderNavigation,
  },
};
</script>