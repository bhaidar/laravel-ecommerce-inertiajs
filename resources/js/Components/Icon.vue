<script setup>
import { computed } from 'vue';
import { camelCase, startCase } from 'lodash';
import * as heroIcons from "@heroicons/vue/24/solid";

const props = defineProps({
  color: String,
  icon: String,
});

const theIcon = computed(() => {
  let pascalStr = startCase(camelCase(props.icon)).replace(/ /g, '');
  return heroIcons[`${pascalStr}Icon`];
});
</script>

<template>
  <component :is="theIcon" class="h-5 w-5" :class="['fill-' + color, 'text-' + color]" />
</template>