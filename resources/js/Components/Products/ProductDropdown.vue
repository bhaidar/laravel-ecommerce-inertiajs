<script setup>
import { computed, ref, watch } from 'vue';

// Events
const emit = defineEmits(['variationChanged']);

// Props
const props = defineProps({
  variations: Object,
});

// Refs
const selectedVariation = ref('');

// Computed
const variationChildren = computed(() => selectedVariation.value?.variations);
const hasChildren = computed(() => variationChildren?.value?.length > 0 );
const variationName = computed(() => props?.variations?.find(Boolean)?.display_name)

// Watch
watch(selectedVariation, (variation) => {
  // handle top-level selection
  onVariationChanged(variation);
});

// Functions
const onVariationChanged = function(variation) {
  emit('variationChanged', variation?.sku ? variation : null);
};

const totalStock = (variation) => {
  return variation?.stocks?.reduce((accumulator, currentValue) => accumulator + currentValue?.amount, 0);
};

</script>

<template>
  <div>
    <div class="mt-3">
      <div class="font-semibold mb-1">
        {{ variationName }}
      </div>

      <select v-model="selectedVariation" class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm">
        <option value="">Choose an option</option>

        <option v-for="variation in variations" :key="variation.id" :value="variation">
          {{ variation.title }}
        </option>
      </select>
    </div>
    <div v-if="hasChildren">
      <!--
        The use of key is essential here. When the selectedVariation changes, it causes the
        product-dropdown to reset its state and redraw it.
      -->
      <product-dropdown
          :key="selectedVariation"
          :variations="variationChildren"
          @variation-changed="onVariationChanged"
      />
    </div>
  </div>
</template>
