<script setup>
import getID from '@/uniqueIds';

defineEmits(['update:modelValue']);
defineProps({
    label: String,
    modelValue: [String, Number],
    options: Array
});

const uuid = getID();
</script>

<template>
  <div class="select">
    <select
        :id="`input${uuid}`"
        class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm"
        :value="modelValue"
        @change="$emit('update:modelValue', $event.target.value)"
        v-bind="$attrs"
    >
      <slot>
        <option
            v-for="option in options"
            :value="option"
            :key="option"
            :selected="option === modelValue"
        >
          {{ option }}
        </option>
      </slot>
    </select>
  </div>
</template>