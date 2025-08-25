<template>
  <div class="min-h-screen bg-white flex flex-col">
    <BaseHeaderNavigation title="Products" />
    <div class="mx-16 my-8">
        <div class="my-6 flex flex-wrap items-center gap-4">
            <div class="flex flex-wrap justify-start gap-2">
                <button
                    type="button"
                    @click="showModal = true"
                    class="bg-soft-gray
                    w-40 rounded-xl
                    border border-black
                    px-4 py-2 text-center"
                >
                    <span class="flex items-center justify-center">
                        <i class="ri-add-line"></i>
                        <span class="pr-1">
                            Add Product
                        </span>
                    </span>
                </button>
            </div>
            <div class="flex flex-wrap justify-start gap-2">
                <button
                    type="button"
                    @click="showModal = true"
                    class="bg-soft-gray
                    w-40 rounded-xl
                    border border-black
                    px-4 py-2 text-center"
                >
                    <span class="flex items-center justify-center">
                        <i class="ri-add-line"></i>
                        <span class="pr-1">
                            Add Variant
                        </span>
                    </span>
                </button>
            </div>
        </div>

        <div class="mt-12 flex flex-wrap items-center justify-between gap-6">
          <div class="flex items-center gap-3">
            <select
              id="variant"
              class="rounded-md border
              border-soft-gray px-4
              py-2 text-sm focus:outline-none
              focus:ring-2 focus:ring-blue-400"
            >
              <option value="" disabled selected>
                Select Variant
              </option>
              <option>
                Fabric
              </option>
              <option>
                Style
              </option>
              <option>
                Lapel
              </option>
              <option>
                Buttons
              </option>
              <option>
                Internal Lining
              </option>
            </select>
          </div>

          <div class="relative">
            <input
              type="text"
              placeholder="Search"
              class="rounded-full
              border border-soft-gray
              px-6 py-2 w-72
              focus:outline-none"
            />
            <button
              class="absolute
              right-0 top-0
              h-full px-4
              bg-soft-gray
              rounded-r-full"
            >
              <i class="ri-search-line"></i>
            </button>
          </div>
        </div>

        <div class="mt-8 mb-16 flex flex-wrap items-center justify-between gap-4">
            <p class="text-gray-800 mb-4">
                Showing 1-10 of 100 results
            </p>
            <div class="flex items-center gap-2">
                <button class="px-3 py-2 bg-gray-200 rounded">
                    <i class="ri-arrow-left-s-line"></i>
                </button>
                <button class="px-3 py-2 bg-soft-gray rounded">
                    1
                </button>
                <button class="px-3 py-2 bg-soft-gray rounded">
                    2
                </button>
                <button class="px-3 py-2 bg-soft-gray rounded">
                    3
                </button>
                <button class="px-3 py-2 bg-gray-200 rounded">
                    <i class="ri-arrow-right-s-line"></i>
                </button>
            </div>
        </div>

        <div
            class="grid grid-cols-1
            sm:grid-cols-2
            md:grid-cols-3
            lg:grid-cols-4 gap-6"
            data-aos="fade-up"
            :data-aos-delay="300"
        >
           <div
              v-for="(product, index) in products"
              :key="index"
              class="border rounded-xl shadow-sm p-4 hover:shadow-md transition flex flex-col justify-between"
            >
              <div class="overflow-hidden rounded-lg mb-4">
                <img
                  :src="product.image || require('@/assets/images/bettania-logo.png')"
                  alt="Variant Image"
                  class="w-full h-48 object-cover transform transition-transform duration-300 hover:scale-105"
                />
              </div>

              <h2 class="text-lg font-semibold text-gray-800 mb-2">
                {{ product.title }}
              </h2>

              <p class="text-sm text-gray-600 mb-4">
                Category: {{ product.category.name }}
              </p>

              <div class="flex justify-end gap-4 text-xl text-gray-500 mt-auto">
                <button @click="editProduct(product)">
                  <i class="ri-edit-2-line hover:text-blue-500"></i>
                </button>
                <button @click="confirmDelete(product)">
                  <i class="ri-delete-bin-line hover:text-red-500"></i>
                </button>
              </div>
            </div>

        </div>
    </div>
    <AddProductModal
        :show="showModal"
        @update:show="val => showModal = val"
        @add-product="handleAddProduct"
    />
    <DeleteProductModal
      :show="showDeleteModal"
      :product="productToDelete"
      @cancel="cancelDelete"
      @confirm="performDelete"
    />
  </div>
</template>

<script>
import axios from 'axios';
import BaseHeaderNavigation from '@/components/Base/BaseHeaderNavigation.vue';
import AddProductModal from '@/components/Modal/AddProductModal.vue'
import DeleteProductModal from '@/components/Modal/DeleteProductModal.vue';

export default {
  components: {
    AddProductModal,
    DeleteProductModal,
    BaseHeaderNavigation,
 },
  data() {
    return {
      showModal: false,
      showDeleteModal: false,
      productToDelete: null,
      products: [],
    };
  },
  mounted() {
    this.fetchVariants();
  },
  methods: {
    fetchVariants() {
      axios.get('/api/v1/variant')
        .then(response => {
          this.products = response.data;
        })
        .catch(error => {
          console.error('Error fetching variants:', error);
        });
    },
    handleAddProduct(product) {
      this.products.push(product);
    },
    confirmDelete(product) {
      this.productToDelete = product;
      this.showDeleteModal = true;
    },
    cancelDelete() {
      this.productToDelete = null;
      this.showDeleteModal = false;
    },
    performDelete() {
      this.products = this.products.filter(p => p !== this.productToDelete);
      this.productToDelete = null;
      this.showDeleteModal = false;
    },
    editProduct(product) {
      console.log("Edit product:", product);
    },
  },
};
</script>