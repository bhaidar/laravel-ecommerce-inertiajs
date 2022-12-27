<script setup>
import {computed} from "vue";
import CartItem from "@/Components/Cart/CartItem.vue";
import LinkButton from "@/Components/LinkButton.vue";

const props = defineProps({
  cart: Object,
});
const isCartEmpty = computed(() => props.cart?.data?.count <= 0);
const variations = computed(() => props.cart?.data?.items);
const total = computed(() => props.cart?.data?.total);
const subTotal = computed(() => props.cart?.data?.subTotal);
</script>

<template>
  <div>
    <div class="overflow-hidden grid grid-cols-6 grid-flow-col gap-4" v-if="!isCartEmpty">
      <div class="p-6 bg-white border-b border-gray-200 col-span-4 -mt-3 self-start">
        <CartItem v-for="variation in variations" :key="variation.id" :item="variation" />
      </div>
      <div class="p-6 bg-white border-b border-gray-200 col-span-2 self-start">
        <div class="space-y-4">
          <div class="space-y-1 flex items-center justify-between">
            <div class="font-semibold">Subtotal</div>
            <h1 class="font-semibold text-xl">
                {{ subTotal }}
            </h1>
          </div>
          <LinkButton :href="route('cart.checkout')">Checkout</LinkButton>
        </div>
      </div>
    </div>
    <div v-else>
      <div class="p-6 bg-white border-b border-gray-200">
        Your cart is empty!
      </div>
    </div>
  </div>
</template>