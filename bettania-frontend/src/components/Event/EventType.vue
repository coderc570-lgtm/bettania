<template>
    <div>
      <h3>Select Event Type</h3>
      <BaseToggle v-model="isOnlineEvent" label="Online Event" />
  
      <!-- Conditionally render fields based on event type -->
      <div v-if="!isOnlineEvent">
        <h4>Non-Online Event</h4>
        <BaseInput
            type="text"
            name="nonOnlineEvent"
            v-model="location" 
            label="Location:"
            placeholder="Enter location"
            customClass="mb-3 w-full"
        />
  
        <!-- Google Maps placeholder -->
        <div class="border w-full h-60 bg-gray-200">
          <p class="text-center">Google Map here</p>
        </div>
      </div>
  
      <div v-else>
        <h4>Online Event</h4>
        <BaseInput
            type="text"
            name="onlineEvent"
            v-model="eventLink" 
            label="Event Link:"
            placeholder="Enter event link"
            customClass=""
        />
        <BaseTextArea 
            type="text"
            name="onlineEvent"
            v-model="eventNote" 
            label="Note:"
            placeholder="Enter a note"
            customClass=""
        />
      </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import BaseToggle from '@/components/Base/BaseToggle.vue';
import BaseInput from '@/components/Base/BaseInput.vue';
import BaseTextArea from '@/components/Base/BaseTextArea.vue';

export default defineComponent({
name: 'EventType',
components: {
    BaseToggle,
    BaseInput,
    BaseTextArea
},
 data() {
    return {
        isOnlineEvent: false,
        location: '',
        eventLink: '',
        eventNote: ''
    }
 }
});
</script>