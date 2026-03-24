<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { MapPin, Bed, Bath } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import guest from '@/routes/guest';
import type { Property } from '@/types/models';

interface Props {
    properties: Property[];
}

defineProps<Props>();

function getPrimaryImage(property: Property): string {
    return property.images?.[0]?.image_path || '/placeholder-property.jpg';
}
</script>

<template>
    <section class="py-16 px-4">
        <div class="mx-auto max-w-7xl">
            <!-- Section Header -->
            <div class="mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-2">
                    Recently Listed Properties
                </h2>
                <p class="text-lg text-gray-600">
                    New properties added to our portfolio
                </p>
            </div>

            <!-- Properties List (Card Layout) -->
            <div v-if="properties.length" class="space-y-4">
                <Link
                    v-for="property in properties"
                    :key="property.id"
                    :href="guest.properties.show(property).url"
                    as="div"
                    class="flex gap-4 bg-white border border-gray-200 rounded-lg p-4 hover:border-blue-400 hover:shadow-md transition-all cursor-pointer"
                >
                    <!-- Image -->
                    <div class="w-40 h-32 bg-gray-200 rounded-lg flex-shrink-0 overflow-hidden">
                        <img
                            :src="getPrimaryImage(property)"
                            :alt="property.title"
                            class="w-full h-full object-cover hover:scale-105 transition-transform"
                        />
                    </div>

                    <!-- Content -->
                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                {{ property.title }}
                            </h3>
                            <div v-if="property.address" class="flex items-center gap-1 text-sm text-gray-600 mb-2">
                                <MapPin class="w-4 h-4" />
                                <span>
                                    {{ property.address.address_line_1 }}, {{ property.address.city }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 line-clamp-2">
                                {{ property.description }}
                            </p>
                        </div>

                        <!-- Features -->
                        <div class="flex gap-4 text-sm text-gray-600">
                            <div class="flex items-center gap-1">
                                <Bed class="w-4 h-4" />
                                <span>{{ property.bedrooms }} Beds</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <Bath class="w-4 h-4" />
                                <span>{{ property.bathrooms }} Baths</span>
                            </div>
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="text-right flex flex-col justify-between">
                        <div class="text-2xl font-bold text-blue-600">
                            ${{ Number(property.price).toLocaleString('en-US', { maximumFractionDigits: 0 }) }}
                        </div>
                        <Button class="bg-blue-600 hover:bg-blue-700 text-white h-auto">
                            View Details
                        </Button>
                    </div>
                </Link>
            </div>

            <!-- Empty State -->
            <div v-else class="text-center py-12 bg-gray-50 rounded-lg">
                <p class="text-lg text-gray-500">
                    No recent properties available at the moment
                </p>
            </div>

            <!-- View All Button -->
            <div class="text-center mt-12">
                <Link :href="guest.properties.index()">
                    <Button class="bg-white hover:bg-gray-50 text-blue-600 border-2 border-blue-600 px-8 py-3 h-auto text-lg">
                        Browse All Listings
                    </Button>
                </Link>
            </div>
        </div>
    </section>
</template>
