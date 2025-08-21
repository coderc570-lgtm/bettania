<template>
  <div>
    <label for="timezone" class="block mb-2">Select Timezone</label>
    <div class="relative" @click="showDropdown = true" ref="dropdownRef">
      <input
        ref="timezoneInput"
        type="text"
        v-model="searchQuery"
        placeholder="Search for a timezone"
        class="w-full p-1.5 bg-gray-50 border border-gray-300 rounded-md mb-2 focus:outline-none focus:ring-2 focus:ring-primary-500"
        @input="filterTimezones"
      />
      <div v-if="showDropdown" class="absolute left-0 right-0 bg-white border border-gray-300 rounded-md z-30 shadow-lg">
        <ul class="max-h-60 overflow-y-auto">
          <li
            v-for="timezone in displayedTimezones"
            :key="timezone.value"
            @click="selectTimezone(timezone)"
            class="p-2 hover:bg-gray-100 cursor-pointer"
          >
            {{ timezone.label }}
          </li>
          <li v-if="displayedTimezones.length === 0" class="p-2 text-gray-500">No timezones available</li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import moment from 'moment-timezone';

// Mapping of timezone names to city names
const timezoneCityMap: Record<string, string> = {
  "Africa/Cairo": "Cairo",
  "Africa/Nairobi": "Nairobi",
  "America/New_York": "New York",
  "America/Los_Angeles": "Los Angeles",
  "Asia/Singapore": "Singapore",
  "Asia/Tokyo": "Tokyo",
  "Europe/London": "London",
  "Australia/Sydney": "Sydney",
};

export default defineComponent({
  name: 'TimezoneDropdown',
  props: {
    modelValue: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      timezones: [] as { value: string; label: string }[],
      searchQuery: '', // Stores the search query
      displayedTimezones: [] as { value: string; label: string }[],
      showDropdown: false,
    };
  },
  mounted() {
    const citySet = new Set();

    // Fetch the timezone names and format them
    this.timezones = moment.tz.names().reduce((acc, timezone: string) => {
      const offset = moment.tz(timezone).utcOffset();
      const formattedOffset = `(GMT${offset >= 0 ? '+' : ''}${(offset / 60).toFixed(2)})`;
      const cityName = timezoneCityMap[timezone] || timezone;
      
      // Only add the timezone if the city name hasn't been added yet
      if (!citySet.has(cityName)) {
        citySet.add(cityName);
        acc.push({
          value: timezone,
          label: `${formattedOffset} ${cityName}`,
        });
      }
      return acc;
    }, [] as { value: string; label: string }[]);

    // Initially display all timezones
    this.displayedTimezones = [...this.timezones];

    // Add click outside listener
    document.addEventListener('click', this.handleClickOutside);
  },
  beforeUnmount() {
    // Clean up listener
    document.removeEventListener('click', this.handleClickOutside);
  },
  methods: {
    filterTimezones() {
      // Filter displayed timezones based on search query
      this.displayedTimezones = this.timezones.filter(timezone =>
        timezone.label.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    },
    selectTimezone(timezone: { value: string; label: string }) {
      this.searchQuery = timezone.label;
      this.showDropdown = false;
      console.log(this.searchQuery);
      // Emit the selected timezone to the parent using v-model
      this.$emit('update:modelValue', timezone.value);
    },
    handleClickOutside(event: MouseEvent) {
      const target = event.target as HTMLElement;
      const dropdownElement = this.$refs.dropdownRef as HTMLElement;

      // Check if the click was outside the input and dropdown
      if (!dropdownElement.contains(target)) {
        this.showDropdown = false;
      }
    },
  },
});
</script>
