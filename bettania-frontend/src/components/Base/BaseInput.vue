<template>
  <div>
    <label :for="id" class="block text-sm font-medium">
      {{ label }}
    </label>
    <input
      :id="id"
      :name="name"
      :type="type"
      :placeholder="placeholder"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      class="w-full border
      rounded-md px-3 py-2
      text-sm"
      :required="required"
    />
  </div>
</template>

<script>

export default {
  name: 'Input',
  props: {
    id: {
      type: String,
      required: true
    },
    name: {
      type: String,
      required: true
    },
    label: {
      type: String,
      required: true
    },
    placeholder: {
      type: String,
      default: ''
    },
    type: {
      type: String,
      default: 'text'
    },
    modelValue: {
      type: String,
      default: ''
    },
    required: {
      type: Boolean,
      default: false
    },
  },
  emits: ['update:modelValue'],
};
</script>
