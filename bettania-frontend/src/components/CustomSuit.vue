<template>
    <div
        class="flex flex-row
        items-center my-10
        space-x-8
        justify-center w-full"
    >
    <div class="w-1/2 bg-gray-100 rounded-lg overflow-hidden relative">
        <!-- <img 
          v-if="selectedFabricId" 
          :src="fabric.find(f => f.id === selectedFabricId)?.image" 
          class="w-full h-full object-cover"
        /> -->
        <img 
          v-if="selectedStyleId" 
          :src="filteredSuitStyles.find(s => s.id === selectedStyleId)?.image" 
          class=" w-full h-full object-scale-down"
        />
        <!-- <img 
          v-if="selectedButtonsId" 
          :src="buttons.find(b => b.id === selectedButtonsId)?.image" 
          class="absolute top-0 left-0 w-full h-full object-scale-down"
        /> -->

        <img 
            v-if="selectedStyleId"
            :src="sleeve.find(s => s.id === filteredSuitStyles.find(style => style.id === selectedStyleId)?.sleeve_id)?.image"
            class="absolute top-0 left-0 w-full h-full object-scale-down"
        />
      </div>

        <div class="flex flex-col px-10">
            <div>
                <p>Choose Fabric</p>
            </div>
            <div class="flex flex-row space-x-4 pb-8 pt-2" 
                data-aos="fade-up"
                data-aos-duration="1000"
            >
                <BaseImageCard 
                    v-for="item in fabric"
                    :key="item.id"
                    :imageSrc="item.image"
                    :title="item.title"
                    :selected="selectedFabricId === item.id"
                    @select="selectFabric(item.id)"
                />
            </div>

            <div>Choose Style</div>
            <div class="flex flex-row space-x-4 pb-8 pt-2" 
                data-aos="fade-up"
                data-aos-duration="1000"
            >
                <BaseImageCard 
                    v-for="item in filteredSuitStyles" 
                    :key="item.id"
                    :imageSrc="item.image" 
                    :title="item.title"
                    :selected="selectedStyleId === item.id"
                    @select="selectStyle(item.id)"
                    custom-img-class="object-scale-down h-[100px] w-[120px]"
                />
            </div>

            <div>Choose Lapel</div>
            <div class="flex flex-row space-x-4 pb-8 pt-2"
                data-aos="fade-up"
                data-aos-duration="1000"
            >
                <BaseWordCard 
                    v-for="item in lapelStyle" 
                    :key="item.id" 
                    :title="item.title"
                    :selected="selectedLapelId === item.id"
                    @select="selectLapel(item.id)"
                />
            </div>

            <div>Choose Buttons</div>
            <div class="flex flex-row space-x-4 pb-8 pt-2"
                data-aos="fade-up"
                data-aos-duration="1000"
            >
                <BaseImageCard 
                    v-for="item in buttons" 
                    :key="item.id"
                    :imageSrc="item.image" 
                    :title="item.title"
                    :selected="selectedButtonsId === item.id"
                    @select="selectButtons(item.id)"
                    custom-img-class="object-scale-down"
                />
            </div>

            <div>Choose Internal Lining</div>
            <div class="flex flex-row space-x-4 pb-8 pt-2"
                data-aos="fade-up"
                data-aos-duration="1000"
            >
                <BaseImageCard 
                    v-for="item in lining" 
                    :key="item.id"
                    :imageSrc="item.image" 
                    :title="item.title"
                    :selected="selectedLiningId === item.id"
                    @select="selectLining(item.id)"
                    custom-img-class="object-none h-[100px] w-[120px]"
                />
            </div>

            <div>
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" class="h-5 w-5 text-blue-600 focus:ring-0 border-gray-300 rounded" v-model="viewTrousers">
                    <span class="text-gray-700">Use a different fabric for trousers</span>
                </label>                  
            </div>

            <div class="pt-4" 
                v-if="viewTrousers" 
                data-aos="fade-up"
                data-aos-duration="1000"
            >
                Choose Trouser Fabric
            </div>
            <div class="flex flex-row space-x-4 pb-8 pt-2"
                data-aos="fade-up"
                data-aos-duration="1000"
                v-if="viewTrousers"
            >
                <BaseImageCard 
                    v-for="item in trousers" 
                    :key="item.id"
                    :imageSrc="item.image" 
                    :title="item.title"
                    :selected="selectedTrousersId === item.id"
                    @select="selectTrousers(item.id)"
                />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import BaseImageCard from './Base/BaseImageCard.vue';
import BaseWordCard from './Base/BaseWordCard.vue';
import { computed, ref } from 'vue'

const fabric = [
    {
        id: 1,
        title: 'Oberon',
        image: getImage('oberon-swatch.jpg'),
    },
    {
        id: 2,
        title: 'Sicilian Grey',
        image: getImage('sicilian-grey-swatch.jpg'),
    }
]

const sleeve = [
    {
        id: 1,
        title: 'Oberon Sleeve',
        image: getImage('lining-sleeves.webp'),
    },
    {
        id: 2,
        title: 'Sicilian Sleeve',
        image: getImage('sicilian-grey-lining-sleeves.webp'),
    }
]

const suitStyle = [
    {
        id: 1,
        title: 'Single-breasted 1 button',
        fabric_id: 1,
        notch_id: 1,
        sleeve_id: 1,
        image: getImage('neck-lapel-notch-1btn.webp'),
    },
    {
        id: 2,
        title: 'Single-breasted 2 button',
        fabric_id: 1,
        notch_id: 1,
        sleeve_id: 1,
        image: getImage('neck-lapel-notch-2btn.webp'),
    },
    {
        id: 3,
        title: 'Double-breasted 4 buttons',
        fabric_id: 1,
        notch_id: 1,
        sleeve_id: 1,
        image: getImage('neck-lapel-notch-double-breasted-4btn.webp'),
    },
    {
        id: 4,
        title: 'Double-breasted 6 buttons',
        fabric_id: 1,
        notch_id: 1,
        sleeve_id: 1,
        image: getImage('neck-lapel-notch-double-breasted-6btn.webp'),
    },
    {
        id: 5,
        title: 'Single-breasted 1 button',
        fabric_id: 2,
        notch_id: 1,
        sleeve_id: 2,
        image: getImage('sicilian-grey-neck-lapel-single-breasted-notch-1btn.webp'),
    },
    {
        id: 6,
        title: 'Single-breasted 2 button',
        fabric_id: 2,
        notch_id: 1,
        sleeve_id: 2,
        image: getImage('sicilian-grey-neck-lapel-single-breasted-notch-2btn.webp'),
    },
    {
        id: 7,
        title: 'Double-breasted 4 buttons',
        fabric_id: 2,
        notch_id: 1,
        sleeve_id: 2,
        image: getImage('sicilian-grey-neck-lapel-double-breasted-notch-4btn.webp'),
    },
    {
        id: 8,
        title: 'Double-breasted 6 buttons',
        fabric_id: 2,
        notch_id: 1,
        sleeve_id: 2,
        image: getImage('sicilian-grey-neck-lapel-double-breasted-notch-6btn.webp'),
    },
    {
        id: 9,
        title: 'Single-breasted 1 button',
        fabric_id: 1,
        notch_id: 2,
        sleeve_id: 1,
        image: getImage('neck-lapel-peak-1btn.webp'),
    },
    {
        id: 10,
        title: 'Single-breasted 2 button',
        fabric_id: 1,
        notch_id: 2,
        sleeve_id: 1,
        image: getImage('neck-lapel-peak-2btn.webp'),
    },
    {
        id: 11,
        title: 'Double-breasted 4 buttons',
        fabric_id: 1,
        notch_id: 2, 
        sleeve_id: 1,       
        image: getImage('neck-lapel-peak-double-breasted-4btn.webp'),
    },
    {
        id: 12,
        title: 'Double-breasted 6 buttons',
        fabric_id: 1,
        notch_id: 2,
        sleeve_id: 1,
        image: getImage('neck-lapel-peak-double-breasted-6btn.webp'),
    },
    {
        id: 13,
        title: 'Single-breasted 1 button',
        fabric_id: 2,
        notch_id: 2,
        sleeve_id: 2,
        image: getImage('sicilian-grey-neck-lapel-single-breasted-peak-1btn.webp'),
    },
    {
        id: 14,
        title: 'Single-breasted 2 button',
        fabric_id: 2,
        notch_id: 2,
        sleeve_id: 2,
        image: getImage('sicilian-grey-neck-lapel-single-breasted-peak-2btn.webp'),
    },
    {
        id: 15,
        title: 'Double-breasted 4 buttons',
        fabric_id: 2,
        notch_id: 2,
        sleeve_id: 2,
        image: getImage('sicilian-grey-neck-lapel-double-breasted-peak-4btn.webp'),
    },
    {
        id: 16,
        title: 'Double-breasted 6 buttons',
        fabric_id: 2,
        notch_id: 2, 
        sleeve_id: 2,       
        image: getImage('sicilian-grey-neck-lapel-double-breasted-peak-6btn.webp'),
    },
]

const lapelStyle = [
    {
        id: 1,
        title: 'Notch',
    },
    {
        id: 2,
        title: 'Peak',
    }
]

const buttons = [
    {
        id: 1,
        title: 'Navy Blue',
        image: getImage('button-navi-blue-thumbnail.avif'),
    },
    {
        id: 2,
        title: 'Brown',
        image: getImage('button-dark-grey-thumbnail.webp'),
    },
    {
        id: 3,
        title: 'Dark Grey',
        image: getImage('button-brown-thumbnail.avif'),
    }
]

const lining = [
    {
        id: 1,
        title: 'Wall Street-Polyester',
        image: getImage('lining-wall-street-thumbnail.jpg'),
    },
    {
        id: 2,
        title: 'Berck-Polyester',
        image: getImage('lining-berck-thumbnail.jpg'),
    },
    {
        id: 3,
        title: 'Anoniz-Polyester',
        image: getImage('lining-inoniz-thumbnail.jpg'),
    }
]

const trousers = [
    {
        id: 1,
        title: 'Oberon',
        image: getImage('oberon-tourser.webp'),
    },
    {
        id: 2,
        title: 'Sicilian Grey',
        image: getImage('sicilian-grey-trouser.webp'),
    }
]

// Track which card is selected
const selectedFabricId = ref<number | null>(1)
const selectedStyleId = ref<number | null>(1)
const selectedLapelId = ref<number | null>(1)
const selectedButtonsId = ref<number | null>(1)
const selectedLiningId = ref<number | null>(1)
const selectedTrousersId = ref<number | null>(1)


// Track checkbox
const viewTrousers = ref<boolean>(false)

function getImage(filename: string) {
  return `/images/${filename}`;
}

function selectFabric(id: number) {
  selectedFabricId.value = id
  selectedLapelId.value = 1
  if(selectedFabricId.value === 1) {
    selectedStyleId.value = 1
  } else {
    selectedStyleId.value = 5
  }
}

function selectStyle(id: number) {
  selectedStyleId.value = id
//   console.log(filteredSuitStyles.value);
}

function selectLapel(id: number) {
  selectedLapelId.value = id
  if(selectedLapelId.value === 1 && selectedFabricId.value === 1) {
    selectedStyleId.value = 1
  } else if (selectedLapelId.value === 1 && selectedFabricId.value === 2) {
    selectedStyleId.value = 5
  } else if (selectedLapelId.value === 2 && selectedFabricId.value === 1) {
    selectedStyleId.value = 9
  } else if (selectedLapelId.value === 2 && selectedFabricId.value === 2) {
    selectedStyleId.value = 13
  } else {
    selectedStyleId.value = null
  }

  console.log(`Selected Lapel: ${selectedLapelId.value}, Selected Fabric: ${selectedFabricId.value}, Selected Style: ${selectedStyleId.value}`);
}

function selectButtons(id: number) {
  selectedButtonsId.value = id
}

function selectLining(id: number) {
  selectedLiningId.value = id
}

function selectTrousers(id: number) {
  selectedTrousersId.value = id
}

const filteredSuitStyles = computed(() => {
  if (!selectedFabricId.value) return []
  return suitStyle.filter(s => s.fabric_id === selectedFabricId.value && s.notch_id === selectedLapelId.value)
})
</script>