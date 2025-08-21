<template>
    <div class="flex flex-col items-center my-10 justify-center w-full md:w-1/2 px-6 py-8 mx-auto lg:py-0">
        <form @submit.prevent="handleSubmit" class="space-y-4 md:space-y-6 p-6">
            <div class="relative w-full mb-5 group">
                <BaseInput
                    type="text"
                    name="title"
                    label="Event Title"
                    placeholder="Name of event"
                    v-model="eventTitle"
                    customClass="w-[620px]"
                />
            </div>
            <div class="relative w-full mb-5 group">
                <BaseInput
                    type="text"
                    name="organizer"
                    label="Organizer name"
                    placeholder="Name of organizer"
                    v-model="eventOrganizerName"
                    customClass="w-[620px]"
                />
            </div>
            <div class="grid md:grid-cols-2 md:gap-3">
                <div class="relative w-full mb-5 group">
                    <BaseSelect
                        name="category"
                        label="Category"
                        :options="mainCategoryOptions()"
                        v-model="selectedCategory"
                        customClass="w-full"
                    />
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <BaseSubSelect
                        name="sub-category"
                        label="Sub-Category"
                        :options="subCategoryOptions()"
                        v-model="selectedSubCategory"
                        customClass="w-full"
                    />
                </div>
            </div>
            <div class="relative w-full mb-5 group">
              <EventType />
            </div>
            <div class="relative w-full mb-5 group">
              <TimezoneDropdown
                class="w-[620px]"
                v-model="selectedTimeZone"
              />
            </div>
            <div class="relative w-full mb-5 group">
              <EventCalendar
                class="w-[620px]"
                v-model="selectedDateTime"
              />
            </div>
            <!-- <div class="relative w-full mb-5 group">
              <EventImage
                class="w-[620px]"
                v-model="ImageTest"
              />
            </div> -->
            <div class="flex flex-col items-center">
              <BaseQuillTextEditor 
                v-model="quillText"
                name="editor"
                label="Your Content" 
                placeholder="Write here..." 
                customClass="my-editor-class w-[620px] mb-4"
                editorHeight="300px"
              />
              <BaseButton
                  label="Submit"
                  type="submit"
                  customClass="w-24 mt-4"
              />
            </div>
        </form>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import BaseButton from '@/components/Base/BaseButton.vue';
import BaseInput from '@/components/Base/BaseInput.vue';
import BaseSelect from '@/components/Base/BaseSelect.vue';
import BaseSubSelect from '@/components/Base/BaseSubSelect.vue';
import EventType from '@/components/Event/EventType.vue';
import TimezoneDropdown from '@/components/Event/TimezoneDropdown.vue';
import EventCalendar from '@/components/Event/EventCalendar.vue';
// import EventImage from '@/components/Event/EventImage.vue';
import BaseQuillTextEditor from '@/components/Base/BaseQuillTextEditor.vue';

export default defineComponent({
  name: 'CreateEvent',
  components: {
    BaseButton,
    BaseInput,
    BaseSelect,
    BaseSubSelect,
    EventType,
    TimezoneDropdown,
    EventCalendar,
    // EventImage,
    BaseQuillTextEditor
   },
  data() {
    return{
        eventTitle: '',
        eventOrganizerName: '',
        selectedCategory: '',
        selectedSubCategory: '',
        selectedTimeZone: '',
        selectedDateTime: { startDate: '', endDate: '', startTime: '', endTime: '', },
        quillText: '',
        ImageTest: '',
    }
  },
  methods: {
    mainCategoryOptions() {
      return [
        { text: 'Select a Category', value: '' },
        { text: 'Music', value: 'Music' },
        { text: 'Sports', value: 'Sports' },
        { text: 'Tournament', value: 'Tournament' }
      ];
    },

    subCategoryOptions() {
      if (this.selectedCategory === 'Music') {
        return [
          { text: 'Select a Sub-Category', value: '' },
          { text: 'Rock', value: 'rock' },
          { text: 'Pop', value: 'pop' },
          { text: 'Jazz', value: 'jazz' },
        ];
      } else if (this.selectedCategory === 'Sports') {
        return [
          { text: 'Select a Sub-Category', value: '' },
          { text: 'Football', value: 'football' },
          { text: 'Basketball', value: 'basketball' },
        ];
      } else if (this.selectedCategory === 'Tournament') {
        return [
          { text: 'Select a Sub-Category', value: '' },
          { text: 'Local', value: 'local' },
          { text: 'National', value: 'national' },
        ];
      }
      return [{ text: 'Select a Sub-Category', value: '' }];
    },

    handleSubmit() {
      console.log('Category:', this.eventTitle);
      console.log('Category:', this.eventOrganizerName);
      console.log('Category:', this.selectedCategory);
      console.log('Sub Cat:', this.selectedSubCategory);
      console.log('Form submitted with timezone:', this.selectedTimeZone);
      console.log('Selected Date Time Object:', this.selectedDateTime);
      console.log('Selected Start Date:', this.selectedDateTime.startDate);
      console.log('Selected End Date:', this.selectedDateTime.endDate);
      console.log('Selected Start Time:', this.selectedDateTime.startTime);
      console.log('Selected End Time:', this.selectedDateTime.endTime);
      console.log('Text:', this.quillText);
    },
  },
  watch: {
    selectedCategory(newVal, oldVal) {
      if (newVal !== oldVal) {
        this.selectedSubCategory = '';
      }
    }
  },
});
</script>