<template>
    <div 
        class="flex flex-row w-full h-dvh" 
    >   
        <div class="w-1/3">
            <!-- TABS -->
            <div
                class="grid grid-cols-4 gap-4 p-4"
            >
                <BaseChips title="Fabric" @click="togglePanel('fabric')"/>
            
                <BaseChips title="Jacket" @click="togglePanel('jacket')"/>
            
                <BaseChips title="Trousers" @click="togglePanel('trouser')"/>
            
                <BaseChips title="Waistcoat" @click="togglePanel('waistcoat')"/>
            </div>

            <!-- SHOW FABRIC -->
             <div class="p-4" 
             v-if="activePanel === 'fabric'">
                <BaseCardList 
                    v-for="fabric in fabricList" 
                    :key="fabric.fabrics_id"
                >
                    <template #title>
                        <p class="font-bold">{{ fabric.fabrics_name }}</p>
                        <p >{{ fabric.fabrics_price }}</p>
                    </template>
                </BaseCardList>
             </div>

             <!-- SHOW JACKET -->
              <div class="p-4" v-if="activePanel === 'jacket'">
                <BaseCardList 
                    v-for="setting in jacketSettingList" 
                    :key="setting.id"
                >
                    <template #title>
                        <p class="font-bold">{{ setting.name }}</p>
                    </template>
                </BaseCardList>
              </div>   
             
              <!-- SHOW TROUSERS -->
              <div class="p-4" v-if="activePanel === 'trouser'">
                <BaseCardList 
                    v-for="setting in trouserSettingList" 
                    :key="setting.id"
                >
                    <template #title>
                        <p class="font-bold">{{ setting.name }}</p>
                    </template>
                </BaseCardList>
              </div>    

              <!-- SHOW WAISTCOAST -->
              <div class="p-4" v-if="activePanel === 'waistcoat'">
                <BaseCardList 
                    v-for="setting in waistCoatSettingList" 
                    :key="setting.id"
                >
                    <template #title>
                        <p class="font-bold">{{ setting.name }}</p>
                    </template>
                </BaseCardList>
              </div>  
        </div>

        <div class="bg-gray-100 w-2/3">
            <p>para sa suit view</p>
        </div>
        
    </div>
</template>

<script setup lang="ts">
import { onMounted } from 'vue';
import BaseCardList from './Base/BaseCardList.vue';
import BaseChips from './Base/BaseChips.vue';
import { axiosInstance } from '@/axios/axios';
import { ref } from 'vue';

const fabricList = ref<any[]>([]);
const jacketSettingList = [
    { id: 1, name: 'Closure'},
    { id: 2, name: 'Button'},
    { id: 3, name: 'Lining'},
    { id: 4, name: 'Lapel'},
];
const trouserSettingList = [
    { id: 1, name: 'Waistband'},
    { id: 2, name: 'Pockets'},
    { id: 3, name: 'Pleat'},
    { id: 4, name: 'Hem Finishing'},
    { id: 5, name: 'Button'},
];
const waistCoatSettingList = [
    { id: 1, name: 'Closure'},
    { id: 2, name: 'Style'},
    { id: 3, name: 'Pocket'},
    { id: 4, name: 'Back Style'},
    { id: 5, name: 'Lining Color'},
    { id: 6, name: 'Button'},
];

const activePanel = ref<string | null>('fabric');

const togglePanel = (panel: string) => {
  activePanel.value = activePanel.value === panel ? null : panel;
};


const getFabrics = async () => {
    try {
        const response = await axiosInstance.post('/v1/fabrics');
        fabricList.value = response.data.body;
        console.log('Fabrics fetched:', fabricList.value);
    } catch (error) {
        console.error('Error fetching fabrics:', error);
    }
}

onMounted(() => {
    getFabrics();
});

</script>
