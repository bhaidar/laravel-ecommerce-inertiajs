<script setup>
import { computed, ref } from 'vue';

const props = defineProps({
  product: Object,
});

const originalImage = ref(props.product?.medias?.[0].originalImage);
const medias = computed(() => props.product?.medias);

const thumbnail = (media) => media?.thumbnails?.[0];

const onSelectedImage = (media) => {
  originalImage.value = media?.originalImage;
}
</script>

<template>
  <div class="flex flex-col space-y-4">
    <img :src="originalImage" alt="">
    <div class="grid grid-cols-6 gap-2">
      <button v-for="media in medias" :key="media" @click="onSelectedImage(media)">
        <img :src="thumbnail(media)" alt="">
      </button>
    </div>
  </div>
</template>