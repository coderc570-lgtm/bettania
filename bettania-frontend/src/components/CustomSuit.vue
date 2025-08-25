<template>
    <div
        class="flex flex-row
        items-center my-10
        space-x-8
        items-stretch
        justify-center w-full"
    >
        <div class="bg-gray-50 rounded-lg shadow-md border border-solid flex flex-col">
            <div class="overflow-hidden relative flex-2">

                <!-- INNER LINING (always under) -->
                <img 
                    v-if="selectedLiningId"
                    :src="lining.find(s => s.id === selectedLiningId)?.upper"
                    class="top-0 left-0 w-full h-full z-0"
                />
    
                <!-- LOWER INNER LINING (always under) -->
                <img 
                    v-if="selectedLiningId"
                    :src="lining.find(s => s.id === selectedLiningId)?.lower"
                    class="absolute top-0 left-0 w-full h-full z-0"
                />

                <!-- Buttons Layer -->
                <img 
                    v-if="selectedButtonImage"
                    :src="selectedButtonImage"
                    class="absolute top-0 left-0 w-full h-full z-20"
                />
            
                <!-- STYLE -->
                <img 
                    v-if="selectedStyleId" 
                    :src="filteredSuitStyles.find(s => s.id === selectedStyleId)?.image" 
                    class="absolute top-0 left-0 w-full h-full z-10"
                />
                
            
                <!-- SLEEVE -->
                <img 
                    v-if="selectedStyleId"
                    :src="sleeve.find(s => s.id === filteredSuitStyles.find(style => style.id === selectedStyleId)?.sleeve_id)?.image"
                    class="absolute top-0 left-0 w-full h-full z-10"
                />
            
                <!-- NECK LINING -->
                <img 
                    v-if="selectedStyleId"
                    :src="sleeve.find(s => s.id === filteredSuitStyles.find(style => style.id === selectedStyleId)?.sleeve_id)?.upper_lining"
                    class="absolute top-0 left-0 w-full h-full z-10"
                />
            
                <!-- BOTTOM -->
                <img 
                    v-if="selectedStyleId"
                    :src="suitBottom.find(s => s.id === filteredSuitStyles.find(style => style.id === selectedStyleId)?.bottom_id)?.image"
                    class="absolute top-0 left-0 w-full h-full z-10"
                />
            
            </div>
    
            <!-- TROUSERS (below top) -->
            <div class="relative w-full mt-2 flex-[1] h-1/2">
                <img 
                    v-if="selectedTrousersId" 
                    :src="trousers.find(s => s.id === selectedTrousersId)?.image" 
                    class="w-full h-full object-none"
                />
            </div>
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

            <!-- <div>
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" class="h-5 w-5 text-blue-600 focus:ring-0 border-gray-300 rounded" v-model="viewTrousers">
                    <span class="text-gray-700">Use a different fabric for trousers</span>
                </label>                  
            </div> -->

            <div>Choose Trouser</div>
            <div class="flex flex-row space-x-4 pt-2"
                data-aos="fade-up"
                data-aos-duration="1000"
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
        upper_lining: getImage('lining-back-upper.webp') 
    },
    {
        id: 2,
        title: 'Sicilian Sleeve',
        image: getImage('sicilian-grey-lining-sleeves.webp'),
        upper_lining: getImage('sicilian-grey-lining-back-upper.webp') 
    }
]

const suitBottom = [
    {
        id: 1,
        name: 'Oberon Single Breast',
        image: getImage('bottom-long-open.webp')
    },
    {
        id: 2,
        name: 'Oberon Double Breast',
        image: getImage('bottom-double-breasted-long.webp')
    },
    {
        id: 3,
        name: 'Sicilian Single Breast',
        image: getImage('sicilian-grey-bottom-single-breasted-long.webp')
    },
    {
        id: 4,
        name: 'Sicilian Double Breast',
        image: getImage('sicilian-grey-bottom-double-breasted-long.webp')
    }
]

const suitStyle = [
    {
        id: 1,
        title: 'Single-breasted 1 button',
        fabric_id: 1,
        notch_id: 1,
        sleeve_id: 1,
        bottom_id: 1,
        image: getImage('neck-lapel-notch-1btn.webp'),
    },
    {
        id: 2,
        title: 'Single-breasted 2 button',
        fabric_id: 1,
        notch_id: 1,
        sleeve_id: 1,
        bottom_id: 1,
        image: getImage('neck-lapel-notch-2btn.webp'),
    },
    {
        id: 3,
        title: 'Double-breasted 4 buttons',
        fabric_id: 1,
        notch_id: 1,
        sleeve_id: 1,
        bottom_id: 2,
        image: getImage('neck-lapel-notch-double-breasted-4btn.webp'),
    },
    {
        id: 4,
        title: 'Double-breasted 6 buttons',
        fabric_id: 1,
        notch_id: 1,
        sleeve_id: 1,
        bottom_id: 2,
        image: getImage('neck-lapel-notch-double-breasted-6btn.webp'),
    },
    {
        id: 5,
        title: 'Single-breasted 1 button',
        fabric_id: 2,
        notch_id: 1,
        sleeve_id: 2,
        bottom_id: 3,
        image: getImage('sicilian-grey-neck-lapel-single-breasted-notch-1btn.webp'),
    },
    {
        id: 6,
        title: 'Single-breasted 2 button',
        fabric_id: 2,
        notch_id: 1,
        sleeve_id: 2,
        bottom_id: 3,
        image: getImage('sicilian-grey-neck-lapel-single-breasted-notch-2btn.webp'),
    },
    {
        id: 7,
        title: 'Double-breasted 4 buttons',
        fabric_id: 2,
        notch_id: 1,
        sleeve_id: 2,
        bottom_id: 4,
        image: getImage('sicilian-grey-neck-lapel-double-breasted-notch-4btn.webp'),
    },
    {
        id: 8,
        title: 'Double-breasted 6 buttons',
        fabric_id: 2,
        notch_id: 1,
        sleeve_id: 2,
        bottom_id: 4,
        image: getImage('sicilian-grey-neck-lapel-double-breasted-notch-6btn.webp'),
    },
    {
        id: 9,
        title: 'Single-breasted 1 button',
        fabric_id: 1,
        notch_id: 2,
        sleeve_id: 1,
        bottom_id: 1,
        image: getImage('neck-lapel-peak-1btn.webp'),
    },
    {
        id: 10,
        title: 'Single-breasted 2 button',
        fabric_id: 1,
        notch_id: 2,
        sleeve_id: 1,
        bottom_id: 1,
        image: getImage('neck-lapel-peak-2btn.webp'),
    },
    {
        id: 11,
        title: 'Double-breasted 4 buttons',
        fabric_id: 1,
        notch_id: 2, 
        sleeve_id: 1, 
        bottom_id: 2,
        image: getImage('neck-lapel-peak-double-breasted-4btn.webp'),
    },
    {
        id: 12,
        title: 'Double-breasted 6 buttons',
        fabric_id: 1,
        notch_id: 2,
        sleeve_id: 1,
        bottom_id: 2,
        image: getImage('neck-lapel-peak-double-breasted-6btn.webp'),
    },
    {
        id: 13,
        title: 'Single-breasted 1 button',
        fabric_id: 2,
        notch_id: 2,
        sleeve_id: 2,
        bottom_id: 3,
        image: getImage('sicilian-grey-neck-lapel-single-breasted-peak-1btn.webp'),
    },
    {
        id: 14,
        title: 'Single-breasted 2 button',
        fabric_id: 2,
        notch_id: 2,
        sleeve_id: 2,
        bottom_id: 3,
        image: getImage('sicilian-grey-neck-lapel-single-breasted-peak-2btn.webp'),
    },
    {
        id: 15,
        title: 'Double-breasted 4 buttons',
        fabric_id: 2,
        notch_id: 2,
        sleeve_id: 2,
        bottom_id: 4,
        image: getImage('sicilian-grey-neck-lapel-double-breasted-peak-4btn.webp'),
    },
    {
        id: 16,
        title: 'Double-breasted 6 buttons',
        fabric_id: 2,
        notch_id: 2, 
        sleeve_id: 2, 
        bottom_id: 4,
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

const buttonStyle = [
    //NAVY SINGLE BREASTED 1BTN
    {
        id: 1,
        title: 'Navy Single Breasted 1btn',
        image: getImage('button-oberon-single-breasted-1btn.png'),
        btn_id: 1,
        style_id: 1
    },
    {
        id: 2,
        title: 'Navy Single Breasted 1btn',
        image: getImage('button-oberon-single-breasted-1btn.png'),
        btn_id: 1,
        style_id: 5
    },
    {
        id: 3,
        title: 'Navy Single Breasted 1btn',
        image: getImage('button-oberon-single-breasted-1btn.png'),
        btn_id: 1,
        style_id: 9
    },
    {
        id: 4,
        title: 'Navy Single Breasted 1btn',
        image: getImage('button-oberon-single-breasted-1btn.png'),
        btn_id: 1,
        style_id: 13
    },
    //BROWN SINGLE BREASTED 1BTN
    {
        id: 5,
        title: 'Brown Single Breasted 1btn',
        image: getImage('button-brown-single-breasted-1btn.webp'),
        btn_id: 2,
        style_id: 1
    },
    {
        id: 6,
        title: 'Brown Single Breasted 1btn',
        image: getImage('button-brown-single-breasted-1btn.webp'),
        btn_id: 2,
        style_id: 5
    },
    {
        id: 7,
        title: 'Brown Single Breasted 1btn',
        image: getImage('button-brown-single-breasted-1btn.webp'),
        btn_id: 2,
        style_id: 9
    },
    {
        id: 8,
        title: 'Brown Single Breasted 1btn',
        image: getImage('button-brown-single-breasted-1btn.webp'),
        btn_id: 2,
        style_id: 13
    },

    //GREY SINGLE BREASTED 1BTN
    {
        id: 9,
        title: 'Grey Single Breasted 1btn',
        image: getImage('button-dark-grey-single-breasted-1btn.png'),
        btn_id: 3,
        style_id: 1
    },
    {
        id: 10,
        title: 'Grey Single Breasted 1btn',
        image: getImage('button-dark-grey-single-breasted-1btn.png'),
        btn_id: 3,
        style_id: 5
    },
    {
        id: 11,
        title: 'Grey Single Breasted 1btn',
        image: getImage('button-dark-grey-single-breasted-1btn.png'),
        btn_id: 3,
        style_id: 9
    },
    {
        id: 12,
        title: 'Grey Single Breasted 1btn',
        image: getImage('button-dark-grey-single-breasted-1btn.png'),
        btn_id: 3,
        style_id: 13
    },

    //NAVY SINGLE BREASTED 2BTN
    {
        id: 13,
        title: 'Navy Single Breasted 2btn',
        image: getImage('button-oberon-single-breasted-2btn.png'),
        btn_id: 1,
        style_id: 2
    },
    {
        id: 14,
        title: 'Navy Single Breasted 2btn',
        image: getImage('button-oberon-single-breasted-2btn.png'),
        btn_id: 1,
        style_id: 6
    },
    {
        id: 15,
        title: 'Navy Single Breasted 2btn',
        image: getImage('button-oberon-single-breasted-2btn.png'),
        btn_id: 1,
        style_id: 10
    },
    {
        id: 16,
        title: 'Navy Single Breasted 2btn',
        image: getImage('button-oberon-single-breasted-2btn.png'),
        btn_id: 1,
        style_id: 14
    },
    //BROWN SINGLE BREASTED 2BTN
    {
        id: 17,
        title: 'Brown Single Breasted 2btn',
        image: getImage('button-brown-single-breasted-2btn.webp'),
        btn_id: 2,
        style_id: 2
    },
    {
        id: 18,
        title: 'Brown Single Breasted 2btn',
        image: getImage('button-brown-single-breasted-2btn.webp'),
        btn_id: 2,
        style_id: 6
    },
    {
        id: 19,
        title: 'Brown Single Breasted 2btn',
        image: getImage('button-brown-single-breasted-2btn.webp'),
        btn_id: 2,
        style_id: 10
    },
    {
        id: 20,
        title: 'Brown Single Breasted 2btn',
        image: getImage('button-brown-single-breasted-2btn.webp'),
        btn_id: 2,
        style_id: 14
    },

    //GREY SINGLE BREASTED 2BTN
    {
        id: 21,
        title: 'Grey Single Breasted 2btn',
        image: getImage('button-dark-grey-single-breasted-2btn.png'),
        btn_id: 3,
        style_id: 2
    },
    {
        id: 22,
        title: 'Grey Single Breasted 2btn',
        image: getImage('button-dark-grey-single-breasted-2btn.png'),
        btn_id: 3,
        style_id: 6
    },
    {
        id: 23,
        title: 'Grey Single Breasted 2btn',
        image: getImage('button-dark-grey-single-breasted-2btn.png'),
        btn_id: 3,
        style_id: 10
    },
    {
        id: 24,
        title: 'Grey Single Breasted 2btn',
        image: getImage('button-dark-grey-single-breasted-2btn.png'),
        btn_id: 3,
        style_id: 14
    },

    //NAVY DOUBLE BREASTED 4BTN
    {
        id: 25,
        title: 'Navy Double Breasted 4btn',
        image: getImage('button-oberon-double-breasted-4btn.png'),
        btn_id: 1,
        style_id: 3
    },
    {
        id: 26,
        title: 'Navy Double Breasted 4btn',
        image: getImage('button-oberon-double-breasted-4btn.png'),
        btn_id: 1,
        style_id: 7
    },
    {
        id: 27,
        title: 'Navy Double Breasted 4btn',
        image: getImage('button-oberon-double-breasted-4btn.png'),
        btn_id: 1,
        style_id: 11
    },
    {
        id: 28,
        title: 'Navy Double Breasted 4btn',
        image: getImage('button-oberon-double-breasted-4btn.png'),
        btn_id: 1,
        style_id: 15
    },

    //BROWN DOOUBLE BREASTED 4BTN
    {
        id: 29,
        title: 'Brown Double Breasted 4btn',
        image: getImage('button-brown-double-breasted-4btn.webp'),
        btn_id: 2,
        style_id: 3
    },
    {
        id: 30,
        title: 'Brown Double Breasted 4btn',
        image: getImage('button-brown-double-breasted-4btn.webp'),
        btn_id: 2,
        style_id: 7
    },
    {
        id: 31,
        title: 'Brown Double Breasted 4btn',
        image: getImage('button-brown-double-breasted-4btn.webp'),
        btn_id: 2,
        style_id: 11
    },
    {
        id: 32,
        title: 'Brown Double Breasted 4btn',
        image: getImage('button-brown-double-breasted-4btn.webp'),
        btn_id: 2,
        style_id: 15
    },

    //GREY DOUBLE BREASTED 4BTN
    {
        id: 33,
        title: 'Grey Double Breasted 4btn',
        image: getImage('button-dark-grey-double-breasted-4btn.png'),
        btn_id: 3,
        style_id: 3
    },
    {
        id: 34,
        title: 'Grey Double Breasted 4btn',
        image: getImage('button-dark-grey-double-breasted-4btn.png'),
        btn_id: 3,
        style_id: 7
    },
    {
        id: 35,
        title: 'Grey Double Breasted 4btn',
        image: getImage('button-dark-grey-double-breasted-4btn.png'),
        btn_id: 3,
        style_id: 11
    },
    {
        id: 36,
        title: 'Grey Double Breasted 4btn',
        image: getImage('button-dark-grey-double-breasted-4btn.png'),
        btn_id: 3,
        style_id: 15
    },

    //NAVY DOUBLE BREASTED 4BTN
    {
        id: 37,
        title: 'Navy Double Breasted 6btn',
        image: getImage('button-oberon-double-breasted-6btn.webp'),
        btn_id: 1,
        style_id: 4
    },
    {
        id: 38,
        title: 'Navy Double Breasted 6btn',
        image: getImage('button-oberon-double-breasted-6btn.webp'),
        btn_id: 1,
        style_id: 8
    },
    {
        id: 39,
        title: 'Navy Double Breasted 6btn',
        image: getImage('button-oberon-double-breasted-6btn.webp'),
        btn_id: 1,
        style_id: 12
    },
    {
        id: 40,
        title: 'Navy Double Breasted 6btn',
        image: getImage('button-oberon-double-breasted-6btn.webp'),
        btn_id: 1,
        style_id: 16
    },

    //BROWN DOOUBLE BREASTED 4BTN
    {
        id: 41,
        title: 'Brown Double Breasted 6btn',
        image: getImage('button-brown-double-breasted-6btn.webp'),
        btn_id: 2,
        style_id: 4
    },
    {
        id: 42,
        title: 'Brown Double Breasted 6btn',
        image: getImage('button-brown-double-breasted-6btn.webp'),
        btn_id: 2,
        style_id: 8
    },
    {
        id: 43,
        title: 'Brown Double Breasted 6btn',
        image: getImage('button-brown-double-breasted-6btn.webp'),
        btn_id: 2,
        style_id: 12
    },
    {
        id: 44,
        title: 'Brown Double Breasted 6btn',
        image: getImage('button-brown-double-breasted-6btn.webp'),
        btn_id: 2,
        style_id: 16
    },

    //GREY DOUBLE BREASTED 4BTN
    {
        id: 45,
        title: 'Grey Double Breasted 6btn',
        image: getImage('button-dark-grey-double-breasted-6btn.png'),
        btn_id: 3,
        style_id: 4
    },
    {
        id: 46,
        title: 'Grey Double Breasted 6btn',
        image: getImage('button-dark-grey-double-breasted-6btn.png'),
        btn_id: 3,
        style_id: 8
    },
    {
        id: 47,
        title: 'Grey Double Breasted 6btn',
        image: getImage('button-dark-grey-double-breasted-6btn.png'),
        btn_id: 3,
        style_id: 12
    },
    {
        id: 48,
        title: 'Grey Double Breasted 6btn',
        image: getImage('button-dark-grey-double-breasted-6btn.png'),
        btn_id: 3,
        style_id: 16
    },
    
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
        image: getImage('button-brown-thumbnail.avif'),
    },
    {
        id: 3,
        title: 'Dark Grey',
        image: getImage('button-dark-grey-thumbnail.webp'),
    }
]

const lining = [
    {
        id: 1,
        title: 'Wall Street-Polyester',
        image: getImage('lining-wall-street-thumbnail.jpg'),
        upper: getImage('lining-back-upper-alt-wall-street.webp'),
        lower: getImage('lining-back-lower-berck-wall-street.webp')
    },
    {
        id: 2,
        title: 'Berck-Polyester',
        image: getImage('lining-berck-thumbnail.jpg'),
        upper: getImage('lining-back-upper-alt-berck.webp'),
        lower: getImage('lining-back-lower-berck.webp')
    },
    {
        id: 3,
        title: 'Anoniz-Polyester',
        image: getImage('lining-inoniz-thumbnail.jpg'),
        upper: getImage('lining-back-upper-alt-inoniz.webp'),
        lower: getImage('lining-back-lower-berck-inoniz.webp')
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
    selectedTrousersId.value = 1
  } else {
    selectedStyleId.value = 5
    selectedTrousersId.value = 2
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

const selectedButtonImage = computed(() => {
  if (!selectedStyleId.value || !selectedButtonsId.value) return null

  const selectedButtonPattern = buttonStyle.find(b => b.btn_id === selectedButtonsId.value && b.style_id === selectedStyleId.value)

//   console.log(selectedButtonPattern, 'style: ' ,selectedStyleId.value, ' button:', selectedButtonsId.value)
  return selectedButtonPattern?.image || null;
})
</script>