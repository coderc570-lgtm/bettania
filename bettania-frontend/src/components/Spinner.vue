<template>
  <div class="flex flex-col items-center justify-center py-20">
    <div
        class="w-16 h-16
        border-4 border-l-deep-plum
        border-r-l-deep-plum
        border-t-l-deep-plum
        border-b-transparent
        rounded-full animate-spin"
    ></div>
    <p class="mt-4 text-deep-plum font-semibold text-lg">
      {{ label }}
    </p>
  </div>
</template>

<script>
export default {
  name: "Spinner",
  props: {
    label: {
      type: String,
      default: "",
    },
  },
};
</script>

<style scoped>
.animate-spin {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>