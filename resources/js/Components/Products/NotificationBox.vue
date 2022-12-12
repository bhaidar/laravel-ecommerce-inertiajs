<script setup>
import { computed } from 'vue';
import { usePage } from "@inertiajs/inertia-vue3";
import Icon from '@/Components/Icon.vue';

// Computed
const icon = computed(() => notification?.color === 'red' ? 'exclamation-circle' : 'check-circle');
const notification = computed({
  get () {
    return usePage().props?.value?.flash?.notification;
  },
  set() {
    usePage().props.value.flash.notification = null;
  },
});

// Functions
const notificationColor = (notification) => notification?.color;
const notificationTitle = (notification) => notification?.title;
const notificationMessage = (notification) => notification?.message;
</script>

<template>
  <div
      class="fixed inset-0 z-50 flex items-end justify-center px-4 py-6 pointer-events-none sm:p-6 sm:items-start sm:justify-end">
    <transition
        appear
        enter-active-class="transform ease-out duration-300 transition"
        enter-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
        leave-active-class="transition ease-in duration-100"
        leave-class="opacity-100"
        leave-to-class="opacity-0">
      <div
          v-if="notification"
          class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden"
      >
        <div class="p-4">
          <div class="flex items-start">
            <div class="flex-shrink-0">
              <Icon :class="'text-' + notificationColor(notification) + '-400'" :icon="icon"/>
            </div>
            <div class="ml-3 w-0 flex-1 pt-0.5">
              <template v-if="notificationTitle(notification) && notificationMessage(notification)">
                <p class="text-sm font-medium text-gray-900">
                  {{ notificationTitle(notification) }}
                </p>
                <p class="mt-1 text-sm text-gray-500">
                  {{ notificationMessage(notification) }}
                </p>
              </template>
              <template v-else>
                <p class="text-sm font-medium text-gray-900">
                  {{ notificationMessage(notification) || notificationTitle(notification) }}
                </p>
              </template>
            </div>
            <div class="ml-4 flex-shrink-0 flex">
              <button
                  class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                  @click="notification = undefined">
                <span class="sr-only">Close</span>
                <icon icon="x-mark"/>
              </button>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>