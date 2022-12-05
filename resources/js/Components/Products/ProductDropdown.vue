<script setup>
import { computed, ref, watch } from 'vue';

const emit = defineEmits(['variationChanged']);

const props = defineProps({
  variations: Object,
});

const selectedVariation = ref('');

watch(selectedVariation, (variation) => {
 emit('variationChanged', variation);
});

// grab the first variation
const variationName = computed(() => props?.variations?.find(Boolean)?.display_name)
</script>

<template>
  <div class="mt-3">
    <div class="font-semibold mb-1">
      {{ variationName }}
    </div>

    <select v-model="selectedVariation" class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm">
      <option value="">Choose an option</option>

      <option v-for="variation in variations" :key="variation.id" :value="variation.id">
        {{ variation.title }}
      </option>
    </select>
  </div>
</template>
