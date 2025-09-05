<template>
    <div 
        class="flex flex-row w-full h-dvh" 
    >   
        <div class="w-1/4">
            <div class="p-4 pb-0">
                <BaseTab
                    :tabs="tabs"
                    :activeTab="activeTab"
                    @update:activeTab="activeTab = $event" 
                />
            </div>

            <Fabric v-if="activeTab === 'Fabric'"/>
            <Jacket v-if="activeTab === 'Jacket'"/>
            <Trouser v-if="activeTab === 'Trouser'"/>
            <WaistCoat v-if="activeTab === 'Waistcoat'"/>
              
        </div>

        <div class="bg-gray-100 w-3/4">
            <p>para sa suit view</p>
        </div>
        
    </div>
</template>

<script>
import Fabric from '@/components/CustomSuits/Fabric.vue';
import BaseTab from './Base/BaseTab.vue';
import Jacket from './CustomSuits/Jacket.vue';
import Trouser from './CustomSuits/Trouser.vue';
import WaistCoat from './CustomSuits/WaistCoat.vue';

export default {
  components: {
    BaseTab,
    Fabric,
    Jacket,
    Trouser,
    WaistCoat
  },
  data() {
    return {
      tabs: [
        'Fabric', 
        'Jacket', 
        'Trouser', 
        'Waistcoat'
      ],
      activeTab: "Fabric",
    };
  },
  mounted() {
    console.log(this.activeTab);
  }
};

</script>
