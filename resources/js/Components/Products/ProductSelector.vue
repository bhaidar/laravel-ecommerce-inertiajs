<script setup>
import {computed, ref, watch} from 'vue';
import ProductDropdown from '@/Components/Products/ProductDropdown.vue';
import orderBy from "lodash/orderBy";
import groupBy from "lodash/groupBy";

const props = defineProps({
  product: Object,
});

const initialVariations = computed(() => {
  if (!props?.product?.variations?.length) {
    return null;
  }

  // sort by order
  const sorted = orderBy(props.product.variations, 'order');
  // group by type
  const grouped = groupBy(sorted, 'type');
  // return first group
  return grouped[Object.keys(grouped)[0]];
});

const selectedVariation = ref('');
const childrenVariations = ref([]);

const onVariationChange = function(variation) {
  selectedVariation.value = variation;
};

const resetChildren = function() {
  childrenVariations.value = [];
};

watch(selectedVariation, (variation) => {
  resetChildren();

  if (!variation) {
    return;
  }

  // load from server related variations
});
</script>

<template>
<div>
  {{ selectedVariation }}
  <div v-if="initialVariations">
    <product-dropdown :variations="initialVariations" @variation-changed="onVariationChange" />
  </div>
</div>
</template>