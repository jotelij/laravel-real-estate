<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import type { BreadcrumbItem, Paginated } from '@/types';
import GuestLayout from '@/layouts/GuestLayout.vue';
import { Property, PropertyFilters } from '@/types/models';
import { PropertyOptions } from '@/types/enums';
import { home } from '@/routes';
import PropertyIndex from '@/components/common/PropertyIndex.vue';

interface Props {
    properties_data: Paginated<Property>;
    filters:  PropertyFilters;
    options:  PropertyOptions;
}

const props = defineProps<Props>(); 

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Property Listings',
        href: home.url(),
    },
];
</script>

<template> 
    <Head title="Property Listings" />

    <GuestLayout>
        <PropertyIndex
            :properties_data="properties_data"
            :filters="filters"
            :options="options" />
    </GuestLayout>
</template>
