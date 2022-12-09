<script setup>
import {computed, ref, toRaw, watch} from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ProductDropdown from '@/Components/Products/ProductDropdown.vue';

// Props
const props = defineProps({
  product: Object,
});

// Refs
const skuVariant = ref(null);
const initialVariations = ref(props?.product?.variations);

// Computed
const hasVariations = computed(() => props?.product?.variations?.length > 0);
const skuVariantPrice = computed(() => skuVariant?.value?.price?.formatted );

// Functions
const onVariationChanged = (variation) => {
  skuVariant.value = variation;
};
const onAddToCart = () => {
};
</script>

<template>
<div class="flex flex-col space-y-6">
  <div v-if="hasVariations">
    <product-dropdown :variations="initialVariations" @variation-changed="onVariationChanged" />
  </div>
  <div v-if="skuVariant">
    <div class="font-semibold text-lg">
      {{ skuVariantPrice }}
    </div>
    <primary-button @click.prevent="onAddToCart">Add to cart</primary-button>
  </div>
</div>
</template>