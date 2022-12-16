<script setup>
import { computed, ref, watch } from 'vue';
import LinkButton from "@/Components/LinkButton.vue";

const props = defineProps({
  item: Object,
});

const selectedQuantity = ref(props.item?.quantity);

watch(selectedQuantity, (newQuantity) => {
  console.log(newQuantity);
});

const variationAncestors = computed(() => props.item?.ancestorsAndSelf);
const variationImage = computed(() => props.item?.medias?.[0]?.originalImage);
const productTitle = computed(() => props.item?.productTitle);
const variationPrice = computed(() => props.item?.price?.formatted);
const variationStockItems = computed(() => {
  return Array.from({length: props.item?.stockFigures?.stockCount}, (_, i) => i + 1);
});
</script>

<template>
  <div class="border-b py-3 flex items-start last:border-0 last:pb-0">
    <div class="w-20 mr-4">
      <img :src="variationImage" class="w-20" alt="">
    </div>

    <div class="space-y-2">
      <div>
        <div class="font-semibold text-lg">
          {{ variationPrice }}
        </div>
        <div class="space-y-1">
          <div>{{ productTitle }}</div>

          <div class="flex items-center text-sm">
            <div v-for="(variation, idx) in variationAncestors" :key="variation.id">
              {{ variation?.title }}
              <span v-if="idx !== variationAncestors?.length - 1" class="text-gray-400 mx-1">/</span>
            </div>
          </div>
        </div>
      </div>

      <div class="flex items-center space-x-4">
        <div class="text-sm flex items-center space-x-2">
          <div class="font-semibold">Quantity</div>
          <select class="text-sm border-none" v-model="selectedQuantity">
            <option v-for="idx in variationStockItems" :value="idx">{{ idx }}</option>
          </select>
        </div>

        <LinkButton class="text-sm">
          Remove
        </LinkButton>
      </div>
    </div>
  </div>

</template>