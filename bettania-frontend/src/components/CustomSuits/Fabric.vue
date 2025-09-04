<template>
    <div class="p-4 overflow-auto max-h-[90%]">
        <div v-if="fabricList.length > 0">
            <BaseCardList 
                v-for="fabric in fabricList" 
                :key="fabric.fabrics_id"
                :value="fabric"
                @select="handleSelect"
            >
                <template #title>
                    <p class="font-bold">{{ fabric.fabrics_name }}</p>
                    <p >{{ fabric.fabrics_price }}</p>
                </template>
            </BaseCardList>
        </div>
        <div v-else-if="loading" class="text-center">
            <p>Loading fabrics ...</p>
        </div>
        <div v-else class="text-center">
            <p>No fabrics available</p>
        </div>
    </div>  
</template>

<script setup lang="ts">
import { onMounted } from 'vue';
import { axiosInstance } from '@/axios/axios';
import { ref } from 'vue';
import BaseCardList from '../Base/BaseCardList.vue';

const fabricList = ref<any[]>([]);
const loading = ref(false);

const getFabrics = async () => {
    try {
        loading.value = true;
        const response = await axiosInstance.post('/v1/fabrics');
        fabricList.value = response.data.body;
        loading.value = false;
        console.log('Fabrics fetched:', fabricList.value);
    } catch (error) {
        console.error('Error fetching fabrics:', error);
    }
}

const handleSelect = (fabric: any) => {
  console.log('Fabric selected:', fabric);
};

onMounted(() => {
    getFabrics();
});

</script>