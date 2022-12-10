<script setup>
import { computed, ref } from 'vue';

const props = defineProps({
  product: Object,
});

const original = ref(props.product?.media?.[0]?.original);
const medias = computed(() => props.product?.media);

const thumbnail = (media) => media?.conversions?.[0];

const selectMedia = (media) => {
  original.value = media?.original;
}
</script>

<template>
  <div class="flex flex-col space-y-4">
    <img :src="original" alt="">
    <div class="grid grid-cols-6 gap-2">
      <button v-for="media in medias" :key="media" @click="selectMedia(media)">
        <img :src="thumbnail(media)" alt="">
      </button>
    </div>
  </div>
</template>