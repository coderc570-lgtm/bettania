<template>
  <div class="min-h-screen bg-white flex flex-col">
    <BaseHeaderNavigation title="Fabrics" />
    <TabSlider
      :tabs="tabs"
      :activeTab="activeTab"
      @update:activeTab="activeTab = $event"
    />
    <Fabric v-if="activeTab === 'Fabric'" />
    <FabricDesign v-if="activeTab === 'Design'" />
    <FabricSeason v-else-if="activeTab === 'Season'" />
    <FabricMaterial v-else-if="activeTab === 'Material'" />
    <FabricMill v-else-if="activeTab === 'Mill'" />
  </div>
</template>

<script>
import BaseHeaderNavigation from "@/components/Base/BaseHeaderNavigation.vue";
import TabSlider from "@/components/TabSlider.vue";
import Fabric from "@/components/Fabrics/Fabric.vue";
import FabricDesign from "@/components/Fabrics/FabricDesign.vue";
import FabricSeason from "@/components/Fabrics/FabricSeason.vue";
import FabricMaterial from "@/components/Fabrics/FabricMaterial.vue";
import FabricMill from "@/components/Fabrics/FabricMill.vue";

export default {
  components: {
    BaseHeaderNavigation,
    TabSlider,
    Fabric,
    FabricDesign,
    FabricSeason,
    FabricMaterial,
    FabricMill,
  },
  data() {
    return {
      tabs: [
        "Fabric",
        "Design",
        "Season",
        "Material",
        "Mill"
      ],
      activeTab: "Fabric",
    };
  },
};
</script>