<template>
    <div class="p-4">
        <div v-if="!showOptions">
            <BaseCardList 
                v-for="setting in jacketSettingList" 
                :key="setting.id"
                :value="setting"
                @select="handleSelect"
            >
                <template #title>
                    <div class="flex flex-row justify-between items-center p-4">
                        <div class="flex flex-col">
                            <p><b>{{ setting.name }}</b></p>
                            <p>No option chosen</p>
                        </div>
                        <i class="ri-arrow-right-s-line"></i>
                    </div>
                </template>
            </BaseCardList>
        </div>

        <div v-if="showOptions" class="overflow-hidden">
            <div v-if="optionList.length > 0">
                <BaseCardList 
                    v-for="option in optionList" 
                    :key="option.id"
                    :value="option"
                    @select="handleSelect"
                >
                    <template #title>
                        <p><b>{{ option.name }}</b></p>
                    </template>
                </BaseCardList>
            </div>
            
            
            <div v-else-if="loading" class="text-center">
                <p>Loading options ...</p>
            </div>
            <div v-else class="text-center">
                <p>No options available</p>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import BaseCardList from '../Base/BaseCardList.vue';
import { axiosInstance } from '@/axios/axios';

const jacketSettingList = [
    { id: 1, name: 'Sleeve'},
    { id: 2, name: 'Closure'},
    { id: 3, name: 'Pocket'},
    { id: 4, name: 'Lapel'},
    { id: 5, name: 'Button'},
];

const optionList = ref<any[]>([]);

let showOptions = ref(false);
let loading = ref(false);

const getData = async (api: string) => {
    try {
        loading.value = true;
        const response = await axiosInstance.post(api);
        showOptions.value = response.data.body;
        loading.value = false;
        console.log('Data fetched:', showOptions.value);
    } catch (error) {
        console.error('Error fetching data', error);
    }
}

const handleSelect = (setting: any) => {
  showOptions.value = true;
  switch(setting.id) {
    case 1:
        optionList.value = [
            { id: 1, name: 'Standard Sleeve'},
            { id: 2, name: 'Working Cuff'},
            { id: 3, name: 'Kissing Button'},
        ];
        break;
    case 2:
        getData('/v1/closures');
        break;
    case 3:
        getData('/v1/pockets');
        break;
    case 4:
        getData('/v1/lapels');
        break;
    case 5:
        getData('/v1/buttons');
        break;
    default:
        optionList.value = [];
  }
};

</script>