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
const variationChildren = computed(() => selectedVariation.value?.children_recursive);
const hasChildren = computed(() => variationChildren?.value?.length > 0 );

// Watch
watch(selectedVariation, (variation) => {
 emit('variationChanged', variation);
});

// Event handlers
const onVariationChanged = function(variation) {
  // get the selected child
  const existingChild = variationChildren?.value?.find((child) => child?.id === variation.id);

  // mark it as selected
  // the watch() is automatically triggered with input of selectedVariation
  existingChild.selected = true;
};

// grab the first variation
const variationName = computed(() => props?.variations?.find(Boolean)?.display_name)
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
      <product-dropdown :variations="variationChildren" @variation-changed="onVariationChanged"/>
    </div>
  </div>
</template>
