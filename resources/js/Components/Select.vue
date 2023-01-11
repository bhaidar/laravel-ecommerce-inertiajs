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
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm h-9 leading-none text-sm"
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