<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
  orders: Object,
});

const orderId = (order) => order?.id;
const orderSubTotal = (order) => order?.subTotal?.formatted;
const orderShippingType = (order) => order?.shippingType?.title;
const orderCreatedAt = (order) => order?.createdAt;
</script>

<template>
  <AppLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Orders
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden sm:rounded-lg space-y-3">

          <template v-if="orders.data.length > 0">
          <div v-for="order in orders.data" :key="order.id"
              class="bg-white p-6 col-span-4 space-y-3">
            <div class="border-b pb-3 flex items-center justify-between">
              <div>#{{ orderId(order) }}</div>
              <div>{{ orderSubTotal(order) }}</div>
              <div>{{  orderShippingType(order) }}</div>
              <div>{{ orderCreatedAt(order) }}</div>
              <div>
                <span class="inline-flex items-center px-3 py-1 text-sm rounded-full font-semibold bg-gray-100 text-gray-800">
                  Order status
                </span>
              </div>
            </div>
            <div class="border-b py-3 space-y-2 flex items-center last:border-0 last:pb-0">
              <div class="w-16 mr-4">
                <img src="" class="w-16">
              </div>

              <div class="space-y-1">
                <div>
                  <div class="font-semibold">Formatted price</div>
                  <div>Variation product title</div>
                </div>

                <div class="flex items-center text-sm">
                  <div class="mr-1 font-semibold">
                    Quantity: 0 <span class="text-gray-400 mx-1">/</span>
                  </div>
                  Variation title <span class="text-gray-400 mx-1">/</span>
                </div>
              </div>
            </div>
          </div>
          </template>
          <template v-else>
            No orders yet
          </template>
        </div>
      </div>
    </div>
  </AppLayout>

</template>