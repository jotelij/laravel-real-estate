<script setup lang="ts">
import DashboardHeader from '@/components/DashboardHeader.vue';
import ListingGrid from '@/components/properties/ListingGrid.vue';
import CustomerLayout from '@/layouts/CustomerLayout.vue';
import { Paginated, Property, PropertyOptions } from '@/types';
import { Head } from '@inertiajs/vue3';


type Props = {
    favourite_properties: Paginated<Property>;
    options:  PropertyOptions;
}

const props = defineProps<Props>(); 

</script>

<template>
    <Head title="Dashboard" />

    <CustomerLayout>
        <div class="flex flex-1 flex-col gap-4 p-4 pt-0">
            <DashboardHeader
                title="My Favourites"
                description="Manage your favourite properties"
            />
            <div
                v-if="props.favourite_properties.data.length"
                class="grid grid-cols-[repeat(auto-fill,minmax(250px,1fr))] gap-3"
            >
                    <ListingGrid
                        v-for="property in props.favourite_properties.data"
                        :key="property.id"
                        :property="property"
                        :view="'grid'"
                        :status-options="props.options.statuses"
                    />
                
            </div>
            <div v-else class="text-center py-16 text-sm text-muted-foreground">
                No properties match your filters.
            </div>
        </div>
    </CustomerLayout>
</template>