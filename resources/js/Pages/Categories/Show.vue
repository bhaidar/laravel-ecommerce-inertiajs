<script setup>
import {computed, toRaw} from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import ProductBrowser from "@/Components/Products/ProductBrowser.vue";
import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
  category: Object,
  products: Object,
  filters: Object,
  maxPrice: Object,
});

const categoryTitle = computed(() => props?.category?.data?.title);
const categoryAncestors = computed(() => props?.category?.data?.ancestors?.reverse());
const categoryData = computed(() => props?.category?.data);
const searchFilters = computed(() => props?.filters?.data);
const productData = computed(() => props?.products?.data);

const ancestorTitle = (category) => category?.title;
const onFiltersChanged = ({ filters, price }) => {
  Inertia.get(route('categories.show',  props?.category.data), { filters, price }, {
    replace: true,
    preserveState: true
  });
};
</script>

<template>
  <AppLayout>
    <template #header>
      <div class="space-x-1">
        <span v-for="(ancestor, idx) in categoryAncestors" :key="ancestor.slug">
          <Link :href="route('categories.show', ancestor)" class="text-indigo-500">
            {{ ancestorTitle(ancestor) }}
          </Link>
          <span class="font-bold text-gray-500" v-if="idx !== categoryAncestors.length - 1"> / </span>
        </span>
        <h2 class="mt-1 font-semibold text-xl text-gray-800 leading-tight">
          {{  categoryTitle }}
        </h2>
      </div>
    </template>

    <ProductBrowser
        :category="categoryData"
        :products="productData"
        :filters="searchFilters"
        :maxPrice="maxPrice"
        @filters-change="onFiltersChanged"
    />
  </AppLayout>
</template>