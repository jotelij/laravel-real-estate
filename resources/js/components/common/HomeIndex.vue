<script setup lang="ts">
import HeroSection from '@/components/home/HeroSection.vue';
import FeaturedProperties from '@/components/home/FeaturedProperties.vue';
import RecentListings from '@/components/home/RecentListings.vue';
import InfoSection from '@/components/home/InfoSection.vue';
import TestimonialsSection from '@/components/home/TestimonialsSection.vue';
import CTASection from '@/components/home/CTASection.vue';
import GuestLayout from '@/layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
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
    <!-- Hero Section -->
    <HeroSection />

    <!-- Featured Properties -->
    <FeaturedProperties
        v-if="featured_properties.length"
        :properties="featured_properties"
        title="Featured Properties"
        description="Explore our handpicked selection of premium properties"
    />

    <!-- Info & Stats Section -->
    <InfoSection :stats="stats" />

    <!-- Recent Listings -->
    <RecentListings
        v-if="recent_properties.length"
        :properties="recent_properties"
    />

    <!-- Testimonials -->
    <TestimonialsSection
        v-if="testimonials.length"
        :testimonials="testimonials"
    />

    <!-- CTA Section -->
    <CTASection />

</template>
