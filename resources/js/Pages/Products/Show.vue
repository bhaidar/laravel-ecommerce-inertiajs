<script setup>
import { computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import ProductSelector from '@/Components/Products/ProductSelector.vue';
import ProductGallery from "@/Components/Products/ProductGallery.vue";

const props = defineProps({
  product: Object,
});

const formattedPrice = computed(() => props.product?.price?.formatted);
</script>

<template>
  <div>
  <AppLayout>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200 grid grid-cols-2 gap-4">
            <div class="col-span-1 grid">
              <product-gallery :product="product" class="mr-4" />
            </div>
            <div class="col-span-1 p-6 space-y-6">
              <div>
                <h1>{{ product?.title }}</h1>
                <h1 class="font-semibold text-xl mt-2">
                  {{ formattedPrice }}
                </h1>
                <p class="mt-2 text-gray-500">
                  {{ product?.description }}
                </p>
              </div>
              <div class="mt-6">
                <product-selector :product="product" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
  </div>
</template>