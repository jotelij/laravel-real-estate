<script setup lang="ts">
import HomeIndex from '@/components/common/HomeIndex.vue';
import GuestLayout from '@/layouts/GuestLayout.vue';
import { Property, Review } from '@/types';
import { Head } from '@inertiajs/vue3';


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
    <Head title="Home" />
    <GuestLayout>
        <HomeIndex
            :featured_properties="featured_properties"
            :recent_properties="recent_properties"
            :stats="stats"
            :testimonials="testimonials"
        />
    </GuestLayout>
</template>