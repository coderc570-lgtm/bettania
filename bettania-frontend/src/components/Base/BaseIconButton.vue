<template>
  <button
    :class="[
      'flex items-center gap-1 rounded-xl px-4 py-2 border',
      variant === 'primary' ? 'bg-deep-plum text-white border-transparent' : 'bg-soft-gray border-black text-black',
      customClass
    ]"
    @click="$emit('click')"
    :data-aos="aos"
  >
    <i :class="icon" v-if="icon" class="text-xl"/>
    <span>{{ label }}</span>
  </button>
</template>

<script>
export default {
  name: "BaseIconButton",
  props: {
    label: {
      type: String,
      required: true
    },
    icon: {
      type: String,
      default: null
    },
    variant: {
      type: String,
      default: 'default'
    },
    customClass: {
      type: String,
      default: ''
    },
    aos: {
      type: String,
      default: ''
    }
  }
};
</script>