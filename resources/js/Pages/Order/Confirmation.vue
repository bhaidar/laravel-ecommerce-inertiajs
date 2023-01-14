<script setup>
import { computed } from 'vue';
import { Head } from '@inertiajs/inertia-vue3';
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
  order: Object,
});

const orderId = computed(() => props?.order?.id);
</script>

<template>
  <Head ><title>Order Confirmation</title></Head>

  <AppLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Thank you for your order
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            Your order (#{{ orderId }}) has been placed. <a href="/" class="text-indigo-500">Create an account</a> to manage your orders.
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
