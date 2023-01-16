<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {computed} from "vue";

const props = defineProps({
  orders: Object,
});

const orderId = (order) => order?.id;
const orderSubTotal = (order) => order?.subTotal?.formatted;
const orderShippingType = (order) => order?.shippingType?.title;
const orderCreatedAt = (order) => order?.createdAt;
const orderVariations = (order) => order?.variations;
const orderStatus = (order) => order?.status;

const orderVariationAncestors = (variation) => variation?.ancestorsAndSelf;
const orderVariationImage = (variation) => variation?.medias?.[0]?.originalImage;
const orderVariationQuantity = (variation) => variation?.quantity;
const orderProductTitle = (variation) => variation?.productTitle;
const orderVariationTitle = (variation) => variation?.title;
const orderVariationPrice = (variation) => variation?.price?.formatted;
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
                  {{ orderStatus(order) }}
                </span>
              </div>
            </div>

              <div v-for="variation in orderVariations(order)" :key="variation.id"
                  class="border-b py-3 space-y-2 flex items-center last:border-0 last:pb-0">
                <div class="w-16 mr-4">
                  <img :src="orderVariationImage(variation)" alt="" class="w-16">
                </div>
                <div class="space-y-1">
                  <div>
                    <div class="font-semibold">{{ orderVariationPrice(variation) }}</div>
                    <div>{{ orderProductTitle(variation) }}</div>
                  </div>
                  <div class="flex items-center text-sm space-x-1">
                    <div class="font-semibold">
                      Quantity: {{ orderVariationQuantity(variation) }} <span class="text-gray-400 mx-1">/</span>
                    </div>
                    <span v-for="(ancestor, idx) in orderVariationAncestors(variation)" :key="ancestor.id">
                            {{ orderVariationTitle(ancestor) }}
                      <span v-if="idx !== orderVariationAncestors(variation)?.length - 1" class="text-gray-400 mx-1">/</span>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </template>
          <template v-else>
            <div class="bg-white p-6 col-span-4 space-y-3">
              No orders yet
            </div>
          </template>
        </div>
      </div>
    </div>
  </AppLayout>

</template>