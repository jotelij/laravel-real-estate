<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import HomeIndex from '@/components/common/HomeIndex.vue';
import CustomerLayout from '@/layouts/CustomerLayout.vue';
import type { Property, Review } from '@/types/models';

interface Props {
    featured_properties: Property[];
    recent_properties: Property[];
    stats: {
        total_properties: number;
        total_agents: number;
        total_reviews: number;
    };
    testimonials: Review[];
}

defineProps<Props>();
</script>

<template>
    <Head title="Home - Real Estate Management" />
    <CustomerLayout :is_wide="true">
        <HomeIndex
            :featured_properties="featured_properties"
            :recent_properties="recent_properties"
            :stats="stats"
            :testimonials="testimonials" />
    </CustomerLayout>
</template>
