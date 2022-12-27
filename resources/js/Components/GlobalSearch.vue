<script setup>
import { ref, watch } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import debounce from 'lodash/debounce';

const search = ref(null);

// Watch
const debouncedWatch = debounce((args) => {
  Inertia.get(route('search'), {
    search: args
  }, {
    preserveState: true,
  });
}, 200);

watch(search, (...args) =>  debouncedWatch(...args));
</script>

<template>
<div class="flex items-center flex-grow">
  <input type="search" placeholder="Search for products"
         v-model="search"
         class="flex-grow text-sm h-10 rounded-md shadow-md border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50"
  >
</div>
</template>