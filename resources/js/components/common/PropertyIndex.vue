<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import FilterSidebar from '@/components/properties/FilterSidebar.vue';
import ListingGrid from '@/components/properties/ListingGrid.vue';
import { usePropertyFilters } from '@/composable/usePropertyFilters';
import type { Paginated } from '@/types';
import type { PropertyOptions } from '@/types/enums';
import type { Property, PropertyFilters } from '@/types/models';

interface Props {
    properties_data: Paginated<Property>;
    filters:  PropertyFilters;
    options:  PropertyOptions;
}

const props = defineProps<Props>(); 

const { filters, clearFilters } = usePropertyFilters(props.filters);
</script>

<template> 
    <div class="flex h-[calc(100vh-64px)] overflow-hidden border rounded-xl">
        <FilterSidebar
            :filters="filters"
            :options="props.options"
            @clear="clearFilters"
        />

        <div class="flex-1 flex flex-col overflow-hidden">
            <div class="flex items-center gap-3 px-4 py-3 border-b">
                <!-- toolbar same as before -->
            </div>

            <p class="text-xs text-muted-foreground px-4 py-2 border-b">
                Showing {{ props.properties_data.total }} properties
            </p>

            <div class="flex-1 overflow-y-auto p-4">
                <div
                    v-if="props.properties_data.data.length"
                    class="grid grid-cols-[repeat(auto-fill,minmax(400px,1fr))] gap-3"
                >
                        <ListingGrid
                            v-for="property in properties_data.data"
                            :key="property.id"
                            :property="property"
                            :view="'grid'"
                            :status-options="options.statuses"
                        />
                    
                </div>
                <div v-else class="text-center py-16 text-sm text-muted-foreground">
                    No properties match your filters.
                </div>
            </div>

            <div class="flex justify-center gap-1 p-3 border-t">
                <Link
                    v-for="link in props.properties_data.links"
                    :key="link.label"
                    :href="link.url ?? '#'"
                    preserve-scroll preserve-state
               
                    class="px-3 py-1 text-sm rounded-md border border-border hover:bg-muted transition-colors"
                    :class="{
                        'bg-primary text-primary-foreground border-primary': link.active,
                        'opacity-40 pointer-events-none': !link.url
                    }"
                >
                    {{ link.label }}
                </Link>
            </div>
        </div>
    </div>
</template>
