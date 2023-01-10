<script setup>
defineEmits(['update:modelValue']);

defineProps({
    label: String,
    modelValue: [String, Number],
    options: Array
});
</script>

<template>
  <select
        class="block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
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
</template>