<script setup>
import {computed, ref, toRaw, watch} from 'vue';
import ProductDropdown from '@/Components/Products/ProductDropdown.vue';

// Props
const props = defineProps({
  product: Object,
});

// Refs
const selectedVariation = ref(null);
const productSku = ref(null);

// Computed
const initialVariations = computed(() => {
  return props?.product?.variations;
});

// Functions
const onVariationChanged = (variation) => {
  selectedVariation.value = variation;
};

function flattenVariations(variation) {
    let result = [];

  variation?.children_recursive?.forEach((variation) => {
      result.push(variation);
      return flattenVariations(variation);
    });

    return result;
  }

// Watch
watch(() => {
  // this is required since selectedVariation is a complex object
  return {
    ...toRaw(selectedVariation.value)
  } }, (variation) => {
  if (!variation) {
    return;
  }

  if (variation?.sku) {
    productSku.value = variation;
    return;
  }

  productSku.value = flattenVariations(variation)?.find((child) => child?.selected && child?.sku);
}, {
  deep: true,
});
</script>

<template>
<div>
  <div v-if="initialVariations">
    {{ productSku }}
    <product-dropdown :variations="initialVariations" @variation-changed="onVariationChanged" />
  </div>
</div>
</template>