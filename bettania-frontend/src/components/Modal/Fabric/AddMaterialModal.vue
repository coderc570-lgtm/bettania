<template>
  <div
    v-if="show"
    class="fixed inset-0
    flex items-center
    justify-center
    bg-black z-50
    bg-opacity-40" 
  >
    <div
      class="bg-white
      p-6 rounded-xl
      shadow-lg w-full
      max-w-md"
      data-aos="zoom-in"
    >
      <h2 class="text-xl font-bold mb-4">
        Add Material
      </h2>

      <BaseInput
        label="Material Name"
        placeholder="Enter Material Name"
        v-model="form.title"
        required
      />

      <BaseSelect
        v-if="heads"
        v-model="form.head_fabric_material_id"
        :options="heads.map(mat => ({
          id: mat.fabric_materials_id,
          title: mat.fabric_materials_title
        }))"
        label="Main Material"
        placeholder="-- Main Category --"
        :disabled="loading"
      />

      <div class="flex justify-end space-x-2">
        <button
          @click="$emit('update:show', false)"
          class="px-4 py-2
          rounded-md bg-gray-200
          hover:bg-gray-300"
          :disabled="loading"
        >
          Cancel
        </button>
        <button
          @click="submit"
          class="px-4 py-2
          rounded-md
          bg-deep-plum
          text-white
          hover:bg-l-deep-plum"
          :disabled="loading"
        >
          {{ loading ? "Adding..." : "Add Material" }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import BaseInput from '@/components/Base/BaseInput.vue'
import BaseSelect from '@/components/Base/BaseSelect.vue'

export default {
  components: {
    BaseInput,
    BaseSelect
  },
  props: {
    show: Boolean,
  },
  data() {
    return {
      loading: false,
      heads: [],
      form: {
        title: "",
        head_fabric_material_id: null,
      },
    };
  },
  watch: {
    show(newVal) {
      if (newVal) {
        this.fetchHeads();
      }
    },
  },
  methods: {
    async fetchHeads() {
      try {
        const res = await this.$axios.post("/v1/fabric-materials", {
          show_only_heads: true,
        });
        this.heads = res.data.body || [];
      } catch (err) {
        console.error("Failed to fetch head materials:", err);
      }
    },
    async submit() {
      if (!this.form.title) {
        this.$notify({
          type: "error",
          title: "Validation",
          text: "Title is required.",
        });
        return;
      }

      this.loading = true;
      try {
        await this.$axios.post("/v1/fabric-materials/store", {
          title: this.form.title,
          head_fabric_material_id: this.form.head_fabric_material_id,
        });

        this.$notify({
          type: "success",
          title: "Saved",
          text: "Material added successfully.",
        });

        this.$emit("saved");
        this.$emit("update:show", false);
        this.form = {
          title: "",
          head_fabric_material_id: null
        };
      } catch (err) {
        console.error(err.response?.data || err);
        this.$notify({
          type: "error",
          title: "Error",
          text: "Failed to add Material.",
        });
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>