<script setup>
import {computed, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ProductDropdown from '@/Components/Products/ProductDropdown.vue';

// Props
const props = defineProps({
  product: Object,
});

// Refs
const skuVariant = ref(null);
const initialVariations = ref(props?.product?.variations);
const resetKey = ref(0);

// Computed
const hasVariations = computed(() => props?.product?.variations?.length > 0);
const skuVariantPrice = computed(() => skuVariant?.value?.price?.formatted );

// Functions
const onVariationChanged = (variation) => {
  skuVariant.value = variation;
};
const onAddToCart = () => {
  Inertia.post(route('cart.variations.store'), {
    variation: skuVariant.value?.id,
  }, {
    onSuccess() {
      resetForm();
    }
  });
};

const resetForm = () => {
  resetKey.value += 1;
  skuVariant.value = null;
};
</script>

<template>
<div class="flex flex-col space-y-6">
  <div v-if="hasVariations">
    <product-dropdown :variations="initialVariations" @variation-changed="onVariationChanged" :key="resetKey" />
  </div>
  <div v-if="skuVariant">
    <div class="font-semibold text-lg">
      {{ skuVariantPrice }}
    </div>
    <primary-button @click.prevent="onAddToCart">Add to cart</primary-button>
  </div>
</div>
</template>