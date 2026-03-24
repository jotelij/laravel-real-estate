<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import type { BreadcrumbItem, Paginated } from '@/types';
import { Property, PropertyFilters } from '@/types/models';
import { PropertyOptions } from '@/types/enums';
import { home } from '@/routes';
import PropertyIndex from '@/components/common/PropertyIndex.vue';
import CustomerLayout from '@/layouts/CustomerLayout.vue';

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

    <CustomerLayout :breadcrumbs="breadcrumbs" :is_wide="true">
        <PropertyIndex
            :properties_data="properties_data"
            :filters="filters"
            :options="options" />
    </CustomerLayout>
</template>
