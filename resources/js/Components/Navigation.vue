<script setup>
import {computed, ref} from "vue";
import {Link, usePage} from '@inertiajs/inertia-vue3';
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import GlobalSearch from "@/Components/GlobalSearch.vue";

const username = computed(() => usePage().props.value?.auth?.user?.name);
const email = computed(() => usePage().props.value?.auth?.user?.email);
const isGuest = computed(() => !usePage().props.value?.auth?.user);
const cartCount = computed(() => usePage().props.value?.cart?.data.count);

const showingNavigationDropdown = ref(false);
</script>

<template>
  <nav class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex flex-grow">
          <!-- Logo -->
          <div class="shrink-0 flex items-center">
            <Link :href="route('dashboard')">
              <ApplicationLogo
                  class="block h-9 w-auto fill-current text-gray-800"/>
            </Link>
          </div>

          <!-- Navigation Links -->
          <div
              class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex flex-grow">
            <NavLink :active="route().current('home')"
                     :href="route('home')">
              Categories
            </NavLink>

            <GlobalSearch />
          </div>
        </div>

        <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-8">
          <!-- Settings Dropdown -->
          <Link :href="route('cart.index')"
                class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
            Cart ({{ cartCount }})
          </Link>
          <Link :href="route('login')" v-if="isGuest"
                class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
            Login
          </Link>
          <Link :href="route('register')" v-if="isGuest"
                class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
            Register
          </Link>

          <div v-if="!isGuest">
            <div class="ml-3 relative">
              <Dropdown align="right" width="48">
                <template #trigger>
                  <span class="inline-flex rounded-md">
                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                            type="button">
                        {{ username }}
                        <svg class="ml-2 -mr-0.5 h-4 w-4"
                             fill="currentColor"
                             viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                clip-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                fill-rule="evenodd"/>
                        </svg>
                    </button>
                  </span>
                </template>

                <template #content>
                  <DropdownLink
                      :href="route('orders.index')">
                    Orders
                  </DropdownLink>
                  <DropdownLink
                      :href="route('profile.edit')">
                    Profile
                  </DropdownLink>
                  <DropdownLink
                      :href="route('logout')"
                      as="button" method="post">
                    Log Out
                  </DropdownLink>
                </template>
              </Dropdown>
            </div>
          </div>
        </div>

        <!-- Hamburger -->
        <div class="-mr-2 flex items-center sm:hidden">
          <button
              class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
              @click="showingNavigationDropdown = !showingNavigationDropdown">
            <svg class="h-6 w-6" fill="none"
                 stroke="currentColor" viewBox="0 0 24 24">
              <path :class="{
                                        hidden: showingNavigationDropdown,
                                        'inline-flex': !showingNavigationDropdown,
                                    }" d="M4 6h16M4 12h16M4 18h16"
                    stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2"/>
              <path :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex': showingNavigationDropdown,
                                    }" d="M6 18L18 6M6 6l12 12"
                    stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2"/>
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
         class="sm:hidden">
      <div class="pt-2 pb-3 space-y-1">
        <ResponsiveNavLink :active="route().current('home')"
                           :href="route('home')">
          Categories
        </ResponsiveNavLink>
      </div>

      <!-- Responsive Settings Options -->
      <div class="pt-4 pb-1 border-t border-gray-200">
        <div v-if="!isGuest">
          <div class="px-4">
            <div
                class="font-medium text-base text-gray-800">
              {{ username }}
            </div>
            <div class="font-medium text-sm text-gray-500">
              {{ email }}
            </div>
          </div>

          <div class="mt-3 space-y-1">
            <ResponsiveNavLink
                :href="route('orders.index')">
              Orders
            </ResponsiveNavLink>
            <ResponsiveNavLink
                :href="route('profile.edit')">
              Profile
            </ResponsiveNavLink>
            <ResponsiveNavLink :href="route('logout')"
                               as="button" method="post">
              Log Out
            </ResponsiveNavLink>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>