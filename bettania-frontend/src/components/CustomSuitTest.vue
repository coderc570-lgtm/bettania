<template>
  <div class="flex flex-col lg:flex-row items-start justify-center w-full my-10 gap-10 px-4">
    <!-- Suit Preview Area -->
    <div class="bg-gray-50 rounded-lg shadow-md border p-4 w-full max-w-md relative">
      <div class="relative w-full h-[500px]">
        <!-- INNER LINING UPPER -->
        <img
          v-if="selectedLiningId"
          :src="lining.find(s => s.id === selectedLiningId)?.upper"
          class="absolute top-0 left-0 w-full h-full z-0"
        />

        <!-- INNER LINING LOWER -->
        <img
          v-if="selectedLiningId"
          :src="lining.find(s => s.id === selectedLiningId)?.lower"
          class="absolute top-0 left-0 w-full h-full z-0"
        />

        <!-- BUTTONS -->
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

      <!-- TROUSERS -->
      <div class="mt-4 w-full h-[200px]">
        <img
          v-if="selectedTrousersId"
          :src="trousers.find(s => s.id === selectedTrousersId)?.image"
          class="w-full h-full object-contain"
        />
      </div>
    </div>

    <!-- Options Panel -->
    <div class="flex flex-col w-full max-w-3xl space-y-8">
      <!-- FABRIC -->
      <div>
        <h3 class="text-lg font-semibold mb-2">Choose Fabric</h3>
        <div class="flex flex-wrap gap-4">
          <BaseImageCard
            v-for="item in fabric"
            :key="item.id"
            :imageSrc="item.image"
            :title="item.title"
            :selected="selectedFabricId === item.id"
            @select="selectFabric(item.id)"
          />
        </div>
      </div>

      <!-- STYLE -->
      <div>
        <h3 class="text-lg font-semibold mb-2">Choose Style</h3>
        <div class="flex flex-wrap gap-4">
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
      </div>

      <!-- LAPEL -->
      <div>
        <h3 class="text-lg font-semibold mb-2">Choose Lapel</h3>
        <div class="flex flex-wrap gap-4">
          <BaseWordCard
            v-for="item in lapelStyle"
            :key="item.id"
            :title="item.title"
            :selected="selectedLapelId === item.id"
            @select="selectLapel(item.id)"
          />
        </div>
      </div>

      <!-- BUTTONS -->
      <div>
        <h3 class="text-lg font-semibold mb-2">Choose Buttons</h3>
        <div class="flex flex-wrap gap-4">
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
      </div>

      <!-- LINING -->
      <div>
        <h3 class="text-lg font-semibold mb-2">Choose Internal Lining</h3>
        <div class="flex flex-wrap gap-4">
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
      </div>

      <!-- TROUSERS -->
      <div>
        <h3 class="text-lg font-semibold mb-2">Choose Trouser</h3>
        <div class="flex flex-wrap gap-4">
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
  </div>
</template>

<script setup lang="ts">
import BaseImageCard from './Base/BaseImageCard.vue';
import BaseWordCard from './Base/BaseWordCard.vue';
import { computed, ref } from 'vue'

// Data arrays (replace image paths with your actual images)
const fabric = ref([
  { id: 1, title: 'Oberon', image: '/images/oberon-swatch.jpg' },
  { id: 2, title: 'Sicilian Grey', image: '/images/sicilian-grey-swatch.jpg' }
]);

const filteredSuitStyles = ref([
  { id: 1, title: 'Single-breasted 1 button', image: '/images/neck-lapel-notch-1btn.webp', sleeve_id: 1, bottom_id: 1 },
  { id: 2, title: 'Single-breasted 2 button', image: '/images/neck-lapel-notch-2btn.webp', sleeve_id: 1, bottom_id: 1 }
]);

const lapelStyle = ref([
  { id: 1, title: 'Notch' },
  { id: 2, title: 'Peak' }
]);

const buttons = ref([
  { id: 1, title: 'Navy Blue', image: '/images/button-navi-blue-thumbnail.avif' },
  { id: 2, title: 'Brown', image: '/images/button-brown-single-breasted-2btn.webp' },
  { id: 3, title: 'Dark Grey', image: '/images/button-dark-grey-thumbnail.webp' }
]);

const lining = ref([
  { id: 1, title: 'Striped Grey', image: 'images/to/lining.jpg', upper: 'images/to/lining-upper.png', lower: 'images/to/lining-lower.png' }
]);

const trousers = ref([
  { id: 1, title: 'Oberon Pants', image: 'images/to/trouser1.png' },
  { id: 2, title: 'Grey Pants', image: 'images/to/trouser2.png' }
]);

const sleeve = ref([
  { id: 1, image: '/images/lining-sleeves.webp', upper_lining: 'images/to/neck-lining.png' }
]);

const suitBottom = ref([
  { id: 1, image: 'images/to/bottom.png' }
]);

// Selected options state
const selectedFabricId = ref(1);
const selectedStyleId = ref(1);
const selectedLapelId = ref(1);
const selectedButtonsId = ref(1);
const selectedLiningId = ref(1);
const selectedTrousersId = ref(1);

// Computed selected button image
const selectedButtonImage = computed(() =>
  buttons.value.find(b => b.id === selectedButtonsId.value)?.image
);

// Selection handlers
const selectFabric = (id: number) => (selectedFabricId.value = id);
const selectStyle = (id: number) => (selectedStyleId.value = id);
const selectLapel = (id: number) => (selectedLapelId.value = id);
const selectButtons = (id: number) => (selectedButtonsId.value = id);
const selectLining = (id: number) => (selectedLiningId.value = id);
const selectTrousers = (id: number) => (selectedTrousersId.value = id);
</script>
