<template>
  <div
    v-if="show"
    class="fixed inset-0
    flex items-center
    justify-center
    bg-black z-50
    bg-opacity-50"
  >
    <div
      class="bg-white
      rounded-xl shadow-lg
      p-6 w-full max-w-lg
      relative"
      data-aos="zoom-in"
    >

      <h2 class="text-xl font-semibold mb-4">
        Edit Material
      </h2>

      <form @submit.prevent="updateMaterial">
        <BaseInput
          label="Material Name"
          placeholder="Enter Material Name"
          v-model="form.title"
          required
        />
        <BaseSelect
          v-if="materials"
          v-model="form.head_fabric_material_id"
          :options="materials.map(mat => ({
            id: mat.fabric_materials_id,
            title: mat.fabric_materials_title
          }))"
          label="Main Material"
          placeholder="-- Main Category --"
          :disabled="loading"
        />
        <div class="flex justify-end space-x-3">
          <button
            type="button"
            class="px-4 py-2
            rounded-lg border
            text-gray-600
            hover:bg-gray-100"
            @click="$emit('update:show', false)"
          >
            Cancel
          </button>
          <button
            type="submit"
            class="px-4 py-2
            rounded-lg
            bg-deep-plum
            text-white
            hover:bg-plum-700"
          >
            {{ loading ? "Updating..." : "Update Material" }}
          </button>
        </div>
      </form>
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
    show: {
      type: Boolean,
      required: true
    },
    material: {
      type: Object,
      default: null
    },
    materials: {
      type: Array, default: () => []
    }, 
  },
  data() {
    return {
      form: {
        id: null,
        title: "",
        head_fabric_material_id: null,
      },
      loading: false,
    };
  },
  watch: {
    material: {
      immediate: true,
      handler(newVal) {
        if (newVal) {
          this.form = {
            id: newVal.fabric_materials_id,
            title: newVal.fabric_materials_title,
            head_fabric_material_id:
              newVal.fabric_materials_head_fabric_material_id || null,
          };
        }
      },
    },
  },
  methods: {
    async updateMaterial() {
      this.loading = true;
      try {
        await this.$axios.put(`/v1/fabric-materials/${this.form.id}`, {
          title: this.form.title,
          head_fabric_material_id: this.form.head_fabric_material_id,
        });

        this.$notify({
          type: "success",
          title: "Updated",
          text: "Material updated successfully",
        });

        this.$emit("updated");
        this.$emit("update:show", false);
      } catch (err) {
        console.error("Failed to update material:", err);
        this.$notify({
          type: "error",
          title: "Error",
          text: "Failed to update Material.",
        });
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>