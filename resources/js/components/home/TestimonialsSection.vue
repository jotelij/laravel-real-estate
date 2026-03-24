<script setup lang="ts">
import { Star } from 'lucide-vue-next';
import type { Review } from '@/types/models';

interface Props {
    testimonials: Review[];
}

defineProps<Props>();

function renderStars(rating: number): number[] {
    return Array.from({ length: 5 }, (_, i) => i < rating ? 1 : 0);
}
</script>

<template>
    <section class="py-16 px-4 bg-white">
        <div class="mx-auto max-w-7xl">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    What Our Customers Say
                </h2>
                <p class="text-lg text-gray-600">
                    Real reviews from satisfied homebuyers and sellers
                </p>
            </div>

            <!-- Testimonials Grid -->
            <div v-if="testimonials.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div
                    v-for="testimonial in testimonials"
                    :key="testimonial.id"
                    class="bg-gray-50 rounded-lg p-6 border border-gray-200 hover:border-blue-300 transition-colors"
                >
                    <!-- Rating Stars -->
                    <div class="flex gap-1 mb-4">
                        <Star
                            v-for="(star, index) in renderStars(testimonial.rating)"
                            :key="index"
                            class="w-5 h-5"
                            :class="star ? 'fill-yellow-400 text-yellow-400' : 'text-gray-300'"
                        />
                    </div>

                    <!-- Review Text -->
                    <p class="text-gray-700 mb-6 line-clamp-3">
                        {{ testimonial.comment }}
                    </p>

                    <!-- User Info -->
                    <div class="border-t border-gray-200 pt-4">
                        <p class="font-semibold text-gray-900">
                            {{ testimonial.user?.name }}
                        </p>
                        <p class="text-sm text-gray-600">
                            {{ testimonial.property?.title }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else class="text-center py-12 bg-gray-50 rounded-lg">
                <p class="text-lg text-gray-500">
                    No testimonials available at the moment
                </p>
            </div>
        </div>
    </section>
</template>
