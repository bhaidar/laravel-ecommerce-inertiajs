<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
  category: Object,
  products: Object,
});

const products = computed(() => props?.products);
const productCountMessage = computed(() => {
  const productCount = products?.value.length;

  return `Found ${ productCount } product${ productCount > 1 ? 's' : ''} matching your filters`;
});

const formattedPrice = (product) => product?.price?.formatted;
const productImage = (product) => product?.medias?.[0]?.originalImage;
const productDescription = (product) => product?.description;
</script>

<template>
  <div class="mx-auto sm:px-6 lg:px-8 max-w-7xl py-12 grid grid-cols-6 gap-4">
    <div class="col-span-1">
      <div class="space-y-6">
        <div class="space-y-1">
          <ul>
            <li>
              <a href="" class="text-indigo-500">
                Category child
              </a>
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

          <div class="space-y-1">
            <div class="font-semibold">Filter title</div>
            <div class="flex items-center space-x-2">
              <input type="checkbox" id="" value=""> <label for="">Filter (count)</label>
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