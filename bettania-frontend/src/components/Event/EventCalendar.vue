<template>
  <div class="grid grid-cols-1 md:grid-cols-2 md:gap-3">
    <div>
      <label for="start-date" class="block mb-1">Start Date</label>
      <DatePicker
        v-model="startDate"
        placeholder="YY/MM/DD"
        :format="dateFormat"
        class="w-full bg-gray-50 border border-gray-300 rounded-md mb-2 focus:outline-none focus:ring-2 focus:ring-primary-500 block p-1.5"
      />
      <label for="start-time" class="block mb-1">Start Time</label>
      <TimePicker
        v-model="startTime"
        :format="timeFormat12"
        class="w-full bg-gray-50 border border-gray-300 rounded-md mb-2 focus:outline-none focus:ring-2 focus:ring-primary-500 block p-1.5"
      />
    </div>
    <div>
      <label for="end-date" class="block mb-1">End Date</label>
      <DatePicker
        v-model="endDate"
        placeholder="YY/MM/DD"
        :format="dateFormat"
        class="w-full bg-gray-50 border border-gray-300 rounded-md mb-2 focus:outline-none focus:ring-2 focus:ring-primary-500 block p-1.5"
      />
      <label for="end-date" class="block mb-1">End Time</label>
      <TimePicker
        v-model="endTime"
        :format="timeFormat12"
        class="w-full bg-gray-50 border border-gray-300 rounded-md mb-2 focus:outline-none focus:ring-2 focus:ring-primary-500 block p-1.5"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, PropType } from 'vue';
import dayjs from 'dayjs';
import DatePicker from 'vue3-datepicker';
import TimePicker from 'vue3-timepicker';
import 'vue3-timepicker/dist/VueTimepicker.css'; // Import the time picker CSS

export default defineComponent({
  name: 'EventCalendar',
  props: {
    modelValue: {
      type: Object as PropType<{ startDate?: string; startTime?: string; endDate?: string; endTime?: string }>,
      default: () => ({ startDate: undefined, startTime: undefined, endDate: undefined, endTime: undefined }),
    },
  },
  components: {
    DatePicker,
    TimePicker
  },
  data() {
    return {
      dateFormat: 'YYYY-MM-DD',
      timeFormat12: 'hh:mm A',
      startDate: this.modelValue.startDate ? new Date(this.modelValue.startDate) : undefined,
      endDate: this.modelValue.endDate ? new Date(this.modelValue.endDate) : undefined,
      startTime: this.modelValue.startTime ? this.modelValue.startTime : undefined,
      endTime: this.modelValue.endTime ? this.modelValue.endTime : undefined,
    };
  },
  watch: {
    modelValue: {
      handler(newValue) {
        // Check if new values are different to avoid unnecessary updates
        if (
          newValue.startDate !== this.formatDate(this.startDate) ||
          newValue.endDate !== this.formatDate(this.endDate) ||
          newValue.startTime !== this.startTime ||
          newValue.endTime !== this.endTime
        ) {
          this.startDate = newValue.startDate ? new Date(newValue.startDate) : undefined;
          this.endDate = newValue.endDate ? new Date(newValue.endDate) : undefined;
          this.startTime = newValue.startTime;
          this.endTime = newValue.endTime;
        }
      },
      immediate: true,
      deep: true,
    },
    startDate(newValue) {
      if (this.modelValue.startDate !== this.formatDate(newValue)) {
        this.emitDateChanges();
      }
    },
    endDate(newValue) {
      if (this.modelValue.endDate !== this.formatDate(newValue)) {
        this.emitDateChanges();
      }
    },
    startTime(newValue) {
      if (this.modelValue.startTime !== newValue) {
        this.emitDateChanges();
      }
    },
    endTime(newValue) {
      if (this.modelValue.endTime !== newValue) {
        this.emitDateChanges();
      }
    },
  },
  methods: {
    formatDate(date: Date | undefined): string | undefined {
      return date ? dayjs(date).format(this.dateFormat) : undefined;
    },
    emitDateChanges() {
      // Emit both the date and time values back to the parent
      this.$emit('update:modelValue', {
        startDate: this.startDate ? dayjs(this.startDate).format(this.dateFormat) : undefined,
        startTime: this.startTime,
        endDate: this.endDate ? dayjs(this.endDate).format(this.dateFormat) : undefined,
        endTime: this.endTime,
      });
    },
  },
});
</script>

