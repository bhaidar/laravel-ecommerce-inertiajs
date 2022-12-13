<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Cart from '@/Components/Cart/Cart.vue';
import { Head } from '@inertiajs/inertia-vue3';

const props = defineProps({
  cart: Object,
});
</script>

<template>
  <Head title="Cart" />

  <AppLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Cart
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <Cart :cart="cart" />
      </div>
    </div>
  </AppLayout>
</template>
