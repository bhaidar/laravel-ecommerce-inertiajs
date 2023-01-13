<script setup>
import { computed, ref, toRaw, watch } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, usePage, useForm } from "@inertiajs/inertia-vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import Select from "@/Components/Select.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
  cart: Object,
  shippingTypes: Object,
  shippingAddresses: Object,
  money: Object,
});

const shippingAddress = ref(null);

const checkoutForm = useForm({
  email: null,
  shipping: {
    address: null,
    city: null,
    postCode: null,
  },
  shippingType: props.shippingTypes?.data?.[0]?.id, // set it to the first element,
});

watch(shippingAddress, function (shippingAddressId) {
  const shippingAddress = toRaw(props.shippingAddresses.data).find(
      (address) => +address.id === +shippingAddressId
  );

  if (shippingAddress) {
    checkoutForm.shipping = { ...shippingAddress };
  }
});

const checkout = () => {
  checkoutForm.post(route('orders.store'), {
    preserveScroll: true,
    onSuccess: () => {
      checkoutForm.reset();
    }
  })
};

const productSlug = (product) => product?.slug;
const variationAncestors = (product) => product?.ancestorsAndSelf;
const variationImage = (product) => product?.medias?.[0]?.thumbnails?.[0] ?? product?.medias?.[0]?.originalImage;
const variationPrice = (product) => product?.price?.formatted;
const variationTitle = (product) => product?.title;
const variationQuantity = (product) => product?.quantity;

const isGuest = computed(() => !usePage().props.value?.auth?.user);

const subTotal = computed(() => props.cart?.data?.subTotal?.amount);
const subTotalFormatted = computed(() => props.cart?.data?.subTotal?.formatted);

const variations = computed(() => props.cart?.data?.items);

const shippingTypeSelected = computed(() => props?.shippingTypes?.data?.find((shippingType) => shippingType.id === checkoutForm?.shippingType));
const shippingSubtotalFormatted = computed(() => shippingTypePriceFormatted(shippingTypeSelected.value));
const shippingSubtotal = computed(() => shippingTypePrice(shippingTypeSelected.value));

const cartTotal = computed(() => Number(subTotal.value) + Number(shippingSubtotal.value));
const cartTotalFormatted = computed(() => {
  return Number(cartTotal.value/100)
      .toLocaleString(props.money?.locale, {
        style: 'currency',
        currency: props.money?.currency,
      });
});

const formattedAddress = (shippingAddress) => {
  return `${shippingAddress.address}, ${shippingAddress.city}, ${shippingAddress.postCode}`;
};

const shippingTypePriceFormatted = (shippingType) => shippingType?.price?.formatted;
const shippingTypePrice = (shippingType) => shippingType?.price?.amount;
const shippingTypeValue = (shippingType) => shippingType?.id;
</script>

<template>
  <Head>
    <title>Checkout</title>
  </Head>

  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Checkout
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form @submit.prevent="checkout">
          <div class="overflow-hidden sm:rounded-lg grid grid-cols-6 grid-flow-col gap-4">
            <div class="p-6 bg-white border-b border-gray-200 col-span-3 self-start space-y-6">
              <div v-if="isGuest" class="space-y-3">
                <div class="font-semibold text-lg">Account details</div>

                <div>
                  <InputLabel for="email" value="Email" />
                  <TextInput id="email" type="text" class="block w-full h-9 text-sm mt-2"
                             placeholder="e.g. bhaidar@gmail.com"
                             v-model="checkoutForm.email"
                             :class="{ 'border-red-500': checkoutForm.errors.email }"
                  />
                  <InputError class="mt-2" :message="checkoutForm.errors.email" />
                </div>
              </div>

              <div class="space-y-3">
                <div class="font-semibold text-lg">Shipping</div>

                <Select class="w-full" v-model="shippingAddress" v-if="!isGuest">
                  <option value="">Choose a pre-saved address</option>
                  <option v-for="shippingAddress in shippingAddresses.data" :key="shippingAddress.id" :value="shippingAddress.id">{{ formattedAddress(shippingAddress) }}</option>
                </Select>

                <div class="space-y-3">
                  <div>
                    <InputLabel for="address" value="Address" />
                    <TextInput id="address" type="text" class="block w-full text-sm mt-2"
                               v-model="checkoutForm.shipping.address"
                               :class="{ 'border-red-500': checkoutForm.errors['shipping.address'] }"
                    />
                    <InputError class="mt-2" :message="checkoutForm.errors['shipping.address']" />
                  </div>

                  <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-1">
                      <InputLabel for="city" value="City" />
                      <TextInput id="city" type="text" class="block w-full text-sm mt-2"
                                 v-model="checkoutForm.shipping.city"
                                 :class="{ 'border-red-500': checkoutForm.errors['shipping.city'] }"
                      />
                      <InputError class="mt-2" :message="checkoutForm.errors['shipping.city']" />
                    </div>
                    <div class="col-span-1">
                      <InputLabel for="postalCode" value="Postal Code" />
                      <TextInput id="postalCode" type="text" class="block w-full text-sm mt-2"
                                 v-model="checkoutForm.shipping.postCode"
                                 :class="{ 'border-red-500': checkoutForm.errors['shipping.postCode'] }"
                      />
                      <InputError class="mt-2" :message="checkoutForm.errors['shipping.postCode']" />
                    </div>
                  </div>
                </div>
              </div>

              <div class="space-y-2">
                <div class="font-semibold text-lg">Delivery</div>

                <div class="space-y-1">
                  <Select class="w-full" v-model="checkoutForm.shippingType">
                    <option v-for="shippingType in shippingTypes.data" :value="shippingTypeValue(shippingType)">
                      {{ shippingType.title }} ({{ shippingTypePriceFormatted(shippingType) }})
                    </option>
                  </Select>
                </div>
              </div>

              <div class="space-y-3">
                <div class="font-semibold text-lg">Payment</div>

                <div>
                  Stripe card form
                </div>
              </div>
            </div>
            <div class="p-6 bg-white border-b border-gray-200 col-span-3 self-start space-y-4">
              <div v-for="product in variations" :key="productSlug(product)">
                <div class="border-b py-3 flex items-start">
                  <div class="w-16 mr-4">
                    <img :src="variationImage(product)" class="w-16" alt="">
                  </div>

                  <div class="space-y-2">
                    <div>
                      <div class="font-semibold">
                        {{ variationPrice(product) }}
                      </div>
                      <div class="space-y-1">
                        <div>{{ variationTitle(product) }}</div>

                        <div class="flex items-center text-sm">
                          <div class="mr-1 font-semibold">
                            Quantity: {{ variationQuantity(product) }} <span class="text-gray-400 mx-1">/</span>
                          </div>
                          <span v-for="(variation, idx) in variationAncestors(product)" :key="variation.id">
                            {{ variationTitle(variation) }}
                            <span v-if="idx !== variationAncestors(product)?.length - 1" class="text-gray-400 mx-1">/</span>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="space-y-4">
                <div class="space-y-1">
                  <div class="space-y-1 flex items-center justify-between">
                    <div class="font-semibold">Subtotal</div>
                    <h1 class="font-semibold">{{ subTotalFormatted }}</h1>
                  </div>

                  <div class="space-y-1 flex items-center justify-between">
                    <div class="font-semibold">Shipping (Shipping type)</div>
                    <h1 class="font-semibold">{{ shippingSubtotalFormatted }}</h1>
                  </div>

                  <div class="space-y-1 flex items-center justify-between">
                    <div class="font-semibold">Total</div>
                    <h1 class="font-semibold">{{ cartTotalFormatted }}</h1>
                  </div>
                </div>

                <PrimaryButton type="submit">
                  Confirm order and pay
                </PrimaryButton>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </app-layout>
</template>