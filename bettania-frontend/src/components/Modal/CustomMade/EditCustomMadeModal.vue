<template>
  <div
    v-if="show"
    class="fixed inset-0
    flex items-center
    justify-center
    bg-black bg-opacity-40"
  >
    <div
      class="bg-white p-6
      rounded-xl shadow-lg
      w-full max-w-md"
      data-aos="zoom-in"
    >
      <h2 class="text-xl font-bold mb-4">
        Edit Custom Made
      </h2>

      <BaseInput
        label="Custom Made Name"
        placeholder="Enter Custom Made Name"
        v-model="form.title"
        required
      />

      <div class="mt-4 flex justify-end space-x-2">
        <button
          @click="closeModal"
          class="px-4 py-2
          rounded-md
          bg-gray-200
          hover:bg-gray-300"
          :disabled="loading"
        >
          Cancel
        </button>
        <button
          @click="submit"
          class="px-4 py-2
          rounded-md bg-black
          text-white
          hover:bg-gray-800
          disabled:opacity-50"
          :disabled="loading"
        >
          {{ loading ? "Updating..." : "Update Custom Made" }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import BaseInput from '@/components/Base/BaseInput.vue'

export default {
  components: {
    BaseInput,
  },
  props: {
    show: Boolean,
    custom: Object,
  },
  data() {
    return {
      form: {
        id: null,
        title: "",
      },
      loading: false,
    };
  },
  watch: {
    custom: {
      immediate: true,
      handler(newCustom) {
        if (newCustom) {
          this.form.id = newCustom.custom_mades_id;
          this.form.title = newCustom.custom_mades_title;
        }
      },
    },
  },
  methods: {
    async submit() {
      if (!this.form.title.trim()) {
        this.$notify?.({
          type: "warning",
          title: "Validation",
          text: "Title cannot be empty.",
        });
        return;
      }

      this.loading = true;
      try {
        await this.$axios.put(`/v1/custom-mades/${this.form.id}`, {
          title: this.form.title,
        });

        this.$notify?.({
          type: "success",
          title: "Updated",
          text: "Custom made updated successfully.",
        });

        this.$emit("updated");
        this.$emit("update:show", false);
      } catch (error) {
        console.error(error.response?.data || error);
        this.$notify?.({
          type: "error",
          title: "Error",
          text: "Failed to update custom made.",
        });
      } finally {
        this.loading = false;
      }
    },
    closeModal() {
      this.$emit("update:show", false);
    },
  },
};
</script>