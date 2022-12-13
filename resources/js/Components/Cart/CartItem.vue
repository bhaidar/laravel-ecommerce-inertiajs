<script setup>
import { computed } from 'vue';
import LinkButton from "@/Components/LinkButton.vue";

const props = defineProps({
  item: Object,
});

const variationTitle = computed(() => props.item?.title);
const variationPrice = computed(() => props.item?.price?.formatted);
</script>

<template>
  <div class="border-b py-3 flex items-start last:border-0 last:pb-0">
    <div class="w-20 mr-4">
      <img src="" class="w-20" alt="">
    </div>

    <div class="space-y-2">
      <div>
        <div class="font-semibold text-lg">
          {{ variationPrice }}
        </div>
        <div class="space-y-1">
          <div>{{ variationTitle }}</div>

          <div class="flex items-center text-sm">
            Variation specifics
          </div>
        </div>
      </div>

      <div class="flex items-center space-x-4">
        <div class="text-sm flex items-center space-x-2">
          <div class="font-semibold">Quantity</div>
          <select class="text-sm border-none">
            <option value="1">1</option>
          </select>
        </div>

        <LinkButton class="text-sm">
          Remove
        </LinkButton>
      </div>
    </div>
  </div>

</template>