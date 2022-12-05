<script setup>
import {computed, ref, watch} from 'vue';
import ProductDropdown from '@/Components/Products/ProductDropdown.vue';

// Props
const props = defineProps({
  product: Object,
});

// Refs
const selectedVariation = ref('');

// Computed
const initialVariations = computed(() => {
  return props?.product?.variations;
});

const onVariationChange = function(variation) {
  selectedVariation.value = variation;
};
</script>

<template>
<div>
  <div v-if="initialVariations">
    {{ selectedVariation }}
    <product-dropdown :variations="initialVariations" @variation-changed="onVariationChange" />
  </div>
</div>
</template>