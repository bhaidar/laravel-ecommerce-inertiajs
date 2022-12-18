<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
  category: Object,
});

const categoryTitle = computed(() => props?.category?.data?.title);
const categoryAncestors = computed(() => props?.category?.data?.ancestors?.reverse());

const ancestorTitle = (category) => category?.title;
</script>

<template>
  <AppLayout>
    <template #header>
      <div class="space-x-1">
        <span v-for="(ancestor, idx) in categoryAncestors" :key="ancestor.slug">
          <Link :href="route('categories.show', ancestor)" class="text-indigo-500">
            {{ ancestorTitle(ancestor) }}
          </Link>
          <span class="font-bold text-gray-500" v-if="idx !== categoryAncestors.length - 1"> / </span>
        </span>
        <h2 class="mt-1 font-semibold text-xl text-gray-800 leading-tight">
          {{  categoryTitle }}
        </h2>
      </div>
    </template>
    Product browser
  </AppLayout>
</template>