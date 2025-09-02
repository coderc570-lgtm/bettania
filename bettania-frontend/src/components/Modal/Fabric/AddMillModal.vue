<template>
  <div
    v-if="show"
    class="fixed
    inset-0 z-50
    flex items-center
    justify-center
    bg-black bg-opacity-40"
  >
    <div
      class="bg-white
      rounded-xl shadow-lg
      w-full max-w-lg p-6
      max-h-[90vh] overflow-auto"
      data-aos="zoom-in"
    >
      <h2 class="text-2xl font-bold mb-4">
        Add Mill
      </h2>

      <form @submit.prevent="addMill" class="space-y-4">
        <BaseInput
          label="Mill Name"
          placeholder="Enter Mill Name"
          v-model="form.title"
          required
        />

        <div class="flex justify-end gap-3 pt-4">
          <button
            type="button"
            @click="closeModal"
            class="px-4 py-2
            rounded-md bg-gray-200
            hover:bg-gray-300"
          >
            Cancel
          </button>
          <button
            type="submit"
            class="px-4 py-2
            rounded-md
            bg-deep-plum
            text-white
            hover:bg-l-deep-plum"
            :disabled="loading"
          >
            {{ loading ? "Adding..." : "Add Mill" }}
          </button>
        </div>
      </form>
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
    show: Boolean
  },
  data() {
    return {
      form: {
        title: ""
      },
      loading: false
    };
  },
  methods: {
    async addMill() {
      if (!this.form.title) {
        return this.$notify({
          type: "error",
          title: "Error",
          text: "Mill name is required."
        });
      }
      try {
        this.loading = true;
        await this.$axios.post("/v1/fabric-mills/store", {
          title: this.form.title
        });
        this.$notify({
          type: "success",
          title: "Created",
          text: "Mill added successfully!"
        });
        this.$emit("saved");
        this.closeModal();
      } catch (err) {
        console.error(err);
        this.$notify({
          type: "error",
          title: "Error",
          text: "Failed to add Mill."
        });
      } finally {
        this.loading = false;
      }
    },
    closeModal() {
      this.$emit("update:show", false);
    }
  }
};
</script>