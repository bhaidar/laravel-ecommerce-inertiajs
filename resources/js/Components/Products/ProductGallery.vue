<script setup>
import { computed, ref } from 'vue';

const props = defineProps({
  product: Object,
});

const original = ref(props.product?.images?.[0]?.original);
const images = computed(() => props.product?.images);

const thumbnail = (image) => image?.conversions?.[0];

const onSelectedImage = (image) => {
  original.value = image?.original;
}
</script>

<template>
  <div class="flex flex-col space-y-4">
    <img :src="original" alt="">
    <div class="grid grid-cols-6 gap-2">
      <button v-for="image in images" :key="image" @click="onSelectedImage(image)">
        <img :src="thumbnail(image)" alt="">
      </button>
    </div>
  </div>
</template>