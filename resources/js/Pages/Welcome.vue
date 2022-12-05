<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Category from '@/Components/Products/Category.vue';

defineProps({
    categories: Object,
});
</script>

<template>

    <Head title="Welcome" />

    <AppLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <div class="overflow-hidden grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                <category :categories="categories" />
              </div>
            </div>
        </div>
    </AppLayout>
</template>
