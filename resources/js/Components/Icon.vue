<script setup>
import { computed } from 'vue';
import { camelCase, startCase } from 'lodash';
import * as heroIcons from "@heroicons/vue/24/solid";

const props = defineProps({
  icon: String,
});

const theIcon = computed(() => {
  let pascalStr = startCase(camelCase(props.icon)).replace(/ /g, '');
  return heroIcons[`${pascalStr}Icon`];
});
</script>

<template>
  <div>
    <component :is="theIcon" class="h-5 w-5" />
  </div>
</template>