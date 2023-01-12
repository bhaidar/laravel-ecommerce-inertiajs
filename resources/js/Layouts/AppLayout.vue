<script setup>
import Navigation from "@/Components/Navigation.vue";
import NotificationBox from "@/Components/Products/NotificationBox.vue";
</script>

<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Navigation -->
    <navigation />

    <!-- Page Heading -->
    <header class="bg-white shadow" v-if="$slots.header">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <slot name="header" />
        </div>
    </header>

    <!-- Page Content -->
    <main>
      <slot />
    </main>

    <!-- Notification Box -->
    <teleport to="#modal-container">
      <NotificationBox />
    </teleport>
  </div>
</template>
