<template>
  <div class="my-4">
    <label v-if="label" class="block text-sm font-medium mb-1">
      {{ label }}
    </label>
    <select
      :model-value="modelValue"
      @change="$emit('update:modelValue', $event.target.value)"
      class="w-full border
      rounded-lg px-3 py-2
      focus:ring
      focus:ring-deep-plum
      focus:outline-none"
      :disabled="disabled"
    >
      <option :value="null">
        {{ placeholder }}
      </option>
      <option
        v-for="option in options"
        :key="option.id"
        :value="option.id"
      >
        {{ option.title }}
      </option>
    </select>
  </div>
</template>

<script setup>
defineProps({
  modelValue: [String, Number, null],
  options: {
    type: Array,
    required: true,
  },
  label: String,
  placeholder: {
    type: String,
    default: '-- Select --',
  },
  disabled: {
    type: Boolean,
    default: false,
  },
})

defineEmits(['update:modelValue'])
</script>