<script setup>
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
  categories: Object,
});

const title = (category) => category?.title;
const slug = (category) => category?.slug;
const depthZero = (category) => category?.depth === 0;
const hasChildren = (category) => category?.children?.length > 0;
const children = (category) => category?.children;
</script>

<template>
  <div v-for="category in categories" :key="slug(category)">
    <Link href="#" :class="{ 'font-bold': depthZero(category) }">{{ title(category) }}</Link>

    <div class="ml-4 my-2" v-if="hasChildren(category)">
      <category :categories="children(category)" />
    </div>
  </div>
</template>