<script setup lang="ts">
import { Home, Users, Star } from 'lucide-vue-next';

interface Stats {
    total_properties: number;
    total_agents: number;
    total_reviews: number;
}

interface Props {
    stats: Stats;
}

defineProps<Props>();
</script>

<template>
    <section class="py-16 px-4 bg-gradient-to-br from-blue-50 to-indigo-50">
        <div class="mx-auto max-w-7xl">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <!-- Total Properties -->
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                        <Home class="w-8 h-8 text-blue-600" />
                    </div>
                    <div class="text-4xl font-bold text-gray-900">
                        {{ stats.total_properties.toLocaleString() }}+
                    </div>
                    <p class="text-gray-600 mt-2">Properties Available</p>
                </div>

                <!-- Total Agents -->
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                        <Users class="w-8 h-8 text-green-600" />
                    </div>
                    <div class="text-4xl font-bold text-gray-900">
                        {{ stats.total_agents.toLocaleString() }}+
                    </div>
                    <p class="text-gray-600 mt-2">Trusted Agents</p>
                </div>

                <!-- Total Reviews -->
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-yellow-100 rounded-full mb-4">
                        <Star class="w-8 h-8 text-yellow-600" />
                    </div>
                    <div class="text-4xl font-bold text-gray-900">
                        {{ stats.total_reviews.toLocaleString() }}+
                    </div>
                    <p class="text-gray-600 mt-2">Customer Reviews</p>
                </div>
            </div>

            <!-- How It Works Section -->
            <div id="how-it-works" class="mt-24">
                <h2 class="text-4xl font-bold text-gray-900 text-center mb-12">
                    How It Works
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- Step 1 -->
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-600 text-white rounded-full font-bold mb-4 text-lg">
                            1
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            Search
                        </h3>
                        <p class="text-gray-600">
                            Browse our extensive collection of properties that match your criteria
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-600 text-white rounded-full font-bold mb-4 text-lg">
                            2
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            Connect
                        </h3>
                        <p class="text-gray-600">
                            Get in touch with our professional agents for more information
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-600 text-white rounded-full font-bold mb-4 text-lg">
                            3
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            Schedule
                        </h3>
                        <p class="text-gray-600">
                            Arrange a viewing at a time that works best for you
                        </p>
                    </div>

                    <!-- Step 4 -->
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-600 text-white rounded-full font-bold mb-4 text-lg">
                            4
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            Own
                        </h3>
                        <p class="text-gray-600">
                            Complete your transaction and move into your new home
                        </p>
                    </div>
                </div>
            </div>

            <!-- Features Section -->
            <div class="mt-24">
                <h2 class="text-4xl font-bold text-gray-900 text-center mb-12">
                    Why Choose Us
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">
                                Expert Agents
                            </h3>
                            <p class="mt-2 text-gray-600">
                                Our team consists of experienced, certified real estate professionals
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">
                                Quality Listings
                            </h3>
                            <p class="mt-2 text-gray-600">
                                All properties are verified and professionally photographed
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">
                                Transparent Pricing
                            </h3>
                            <p class="mt-2 text-gray-600">
                                No hidden fees - see exactly what you're getting
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">
                                24/7 Support
                            </h3>
                            <p class="mt-2 text-gray-600">
                                Our team is always ready to answer your questions
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
