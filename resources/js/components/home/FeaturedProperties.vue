<script setup lang="ts">
import type { Property } from '@/types/models';
import { Link } from '@inertiajs/vue3';
import guest from '@/routes/guest';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Heart, MapPin, Bed, Bath, Square } from 'lucide-vue-next';
import { ref } from 'vue';

interface Props {
    properties: Property[];
    title?: string;
    description?: string;
}

defineProps<Props>();

const favorites = ref<Set<number>>(new Set());

function toggleFavorite(propertyId: number) {
    if (favorites.value.has(propertyId)) {
        favorites.value.delete(propertyId);
    } else {
        favorites.value.add(propertyId);
    }
}

function getPrimaryImage(property: Property): string {
    return property.images?.[0]?.image_path || '/placeholder-property.jpg';
}
</script>

<template>
    <section class="py-16 px-4 bg-gray-50">
        <div class="mx-auto max-w-7xl">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    {{ title || 'Featured Properties' }}
                </h2>
                <p class="text-lg text-gray-600">
                    {{ description || 'Explore our handpicked selection of premium properties' }}
                </p>
            </div>

            <!-- Properties Grid -->
            <div v-if="properties.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    v-for="property in properties"
                    :key="property.id"
                    class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow overflow-hidden"
                >
                    <!-- Property Image -->
                    <div class="relative aspect-video bg-gray-200 overflow-hidden group">
                        <img
                            :src="getPrimaryImage(property)"
                            :alt="property.title"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                        />
                        <!-- Featured Badge -->
                        <Badge v-if="property.is_featured" class="absolute top-3 left-3 bg-red-500 hover:bg-red-600">
                            Featured
                        </Badge>
                        <!-- Favorite Button -->
                        <button
                            @click="toggleFavorite(property.id)"
                            class="absolute top-3 right-3 bg-white rounded-full p-2 shadow-md hover:shadow-lg transition-shadow"
                        >
                            <Heart
                                class="w-5 h-5"
                                :class="favorites.has(property.id) ? 'fill-red-500 text-red-500' : 'text-gray-400'"
                            />
                        </button>
                    </div>

                    <!-- Property Details -->
                    <div class="p-4">
                        <!-- Title -->
                        <Link :href="guest.properties.show(property).url" class="hover:text-blue-600">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                {{ property.title }}
                            </h3>
                        </Link>

                        <!-- Location -->
                        <div v-if="property.address" class="flex items-start gap-2 mb-3 text-sm text-gray-600">
                            <MapPin class="w-4 h-4 flex-shrink-0 mt-0.5" />
                            <span class="line-clamp-1">
                                {{ property.address.address_line_1 }}, {{ property.address.city }}
                            </span>
                        </div>

                        <!-- Features -->
                        <div class="flex gap-4 mb-4 text-sm text-gray-600">
                            <div class="flex items-center gap-1">
                                <Bed class="w-4 h-4" />
                                <span>{{ property.bedrooms }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <Bath class="w-4 h-4" />
                                <span>{{ property.bathrooms }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <Square class="w-4 h-4" />
                                <span>{{ property.floor_area }} sqft</span>
                            </div>
                        </div>

                        <!-- Price and CTA -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <div class="text-2xl font-bold text-blue-600">
                                ${{ Number(property.price).toLocaleString('en-US', { maximumFractionDigits: 0 }) }}
                            </div>
                            <Link
                                :href="guest.properties.show(property).url"
                                as="button"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium"
                            >
                                View
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else class="text-center py-12">
                <p class="text-lg text-gray-500">
                    No properties available at the moment
                </p>
            </div>

            <!-- View All Button -->
            <div class="text-center mt-12">
                <Link :href="guest.properties.index()">
                    <Button class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 h-auto text-lg">
                        View All Properties
                    </Button>
                </Link>
            </div>
        </div>
    </section>
</template>
