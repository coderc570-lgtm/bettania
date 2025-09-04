<template>
  <div class="min-h-screen bg-white flex flex-col">
    <BaseHeaderNavigation title="Pocket" />
    <TabSlider
      :tabs="tabs"
      :activeTab="activeTab"
      @update:activeTab="activeTab = $event"
    />
    <PocketType v-if="activeTab === 'Type'"/>
    <Pocket v-if="activeTab === 'Pocket'"/>
  </div>
</template>

<script>
import BaseHeaderNavigation from "@/components/Base/BaseHeaderNavigation.vue";
import PocketType from "@/components/Table/PocketTypeTable.vue";
import Pocket from "@/components/Table/PocketTable.vue";
import TabSlider from "@/components/TabSlider.vue";

export default {
  components: {
    Pocket,
    PocketType,
    TabSlider,
    BaseHeaderNavigation,
  },
  data() {
    return {
      tabs: [
        "Type",
        "Pocket",
      ],
      activeTab: "Type",
    };
  },
};
</script>