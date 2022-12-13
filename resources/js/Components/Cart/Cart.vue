<script setup>
import {computed} from "vue";
// import { Inertia } from '@inertiajs/inertia'
import LinkButton from "@/Components/LinkButton.vue";
import CartItem from "@/Components/Cart/CartItem.vue";

const props = defineProps({
  cart: Object,
});

const cartExists = computed(() => props.cart?.count > 0);
const variations = computed(() => props.cart?.content);
const total = computed(() => props.cart?.total);

// const removeFromCart = function(product) {
//   Inertia.delete(route('cart.products.destroy', product));
// }
</script>

<template>
  <div class="overflow-hidden grid grid-cols-6 grid-flow-col gap-4">
    <div class="p-6 bg-white border-b border-gray-200 col-span-4 -mt-3 self-start">
      <template v-if="cartExists">
        <CartItem v-for="variation in variations" :key="variation.id" :item="variation" />
        <div class="mt-4">
          <div class="mb-2">Cart Total: {{ total }}</div>
          <!-- :href="route('checkout.index')" -->
          <LinkButton>Checkout</LinkButton>
        </div>
      </template>
      <template v-else>
          Your cart is empty
      </template>
    </div>
    <div class="p-6 bg-white border-b border-gray-200 col-span-2 self-start">
      Cart summary
    </div>
  </div>
</template>