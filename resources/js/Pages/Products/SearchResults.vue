<script setup>
import { computed } from "vue";
import { Link } from '@inertiajs/inertia-vue3';
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
  products: Object,
});

const searchHasProducts = computed(() => props?.products?.data?.length > 0);

// Functions
const formattedPrice = (product) => product?.price?.formatted;
const productSlug = (product) => product?.slug;
const productTitle = (product) => product?.title;
</script>

<template>
  <AppLayout>
    <template #header>
      <div class="space-x-1">
        <h2 class="mt-1 font-semibold text-xl text-gray-800 leading-tight">
          Search Results
        </h2>
      </div>
    </template>

    <div class="mx-auto sm:px-6 lg:px-8 max-w-7xl py-12">
      <div class="grid grid-cols-2 column-gap-6" v-if="searchHasProducts">
        <Link
            v-for="product in products.data" :key="productSlug(product)"
            :href="route('products.show', product)"
            class="border-b py-3 mr-4 space-y-2 flex items-center">
          <div>
            <div class="font-semibold text-lg">{{  formattedPrice(product) }}</div>
            <div>{{ productTitle(product) }}</div>
          </div>
        </Link>
      </div>
      <template v-else>
        No products found
      </template>
    </div>
  </AppLayout>
</template>