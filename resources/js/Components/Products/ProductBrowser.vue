<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
  category: Object,
  products: Object,
  filters: Object,
});

const categoryChildren = computed(() => props?.category?.children);
const hasChildren = computed(() => props?.category?.children?.length > 0);
const products = computed(() => props?.products);
const productCountMessage = computed(() => {
  const productCount = products?.value.length;

  return `Found ${ productCount } product${ productCount > 1 ? 's' : ''} matching your filters`;
});

const formattedPrice = (product) => product?.price?.formatted;
const productImage = (product) => product?.medias?.[0]?.originalImage;
const productDescription = (product) => product?.description;
const cleanFilter = (filter) => filter?.replace(/[\[\]]/g, "");
</script>

<template>
  <div class="mx-auto sm:px-6 lg:px-8 max-w-7xl py-12 grid grid-cols-6 gap-4">
    <div class="col-span-1">
      <div class="space-y-6">
        <div class="space-y-1" v-if="hasChildren">
          <ul>
            <li v-for="child in categoryChildren" :key="child.slug">
              <Link :href="route('categories.show', child)" class="text-indigo-500">
                {{  child.title }}
              </Link>
            </li>
          </ul>
        </div>

        <div class="space-y-6">
          <div class="space-y-1">
            <div class="font-semibold">Max price ($0)</div>
            <div class="flex items-center space-x-2">
              <input type="range" min="0" max="">
            </div>
          </div>

          <div class="space-y-1" v-for="(filterBucket, filterProp) in filters" :key="props">
            <div class="font-semibold">{{  filterProp }}</div>
            <div class="flex items-center space-x-2" v-for="(filterValue, filterKey) in filterBucket" :key="filterKey">
              <input type="checkbox" :id="cleanFilter(filterKey)" :value="cleanFilter(filterKey)"> <label :for="cleanFilter(filterKey)">{{  cleanFilter(filterKey)  }} ({{ filterValue }})</label>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-span-5 sm:px-6 lg:px-8">
      <div class="mb-6">
        {{ productCountMessage }}
      </div>

      <div class="overflow-hidden sm:rounded-lg grid lg:grid-cols-3 md:grid-cols-2 gap-4">
        <Link
            v-for="product in products" :key="product.slug"
            :href="route('products.show', product)"
            class="p-6 bg-white border-b border-gray-200 space-y-4">

          <img :src="productImage(product)" class="w-full" :alt="productDescription(product)">

          <div class="space-y-1">
            <div>{{ product?.title }}</div>
            <div class="font-semibold text-lg">
              {{ formattedPrice(product) }}
            </div>
          </div>

        </Link>
      </div>
    </div>
  </div>
</template>