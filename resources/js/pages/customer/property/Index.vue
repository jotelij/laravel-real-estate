<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PropertyIndex from '@/components/common/PropertyIndex.vue';
import CustomerLayout from '@/layouts/CustomerLayout.vue';
import { home } from '@/routes';
import type { BreadcrumbItem, Paginated } from '@/types';
import type { PropertyOptions } from '@/types/enums';
import type { Property, PropertyFilters } from '@/types/models';

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
            :properties_data="props.properties_data"
            :filters="props.filters"
            :options="props.options" />
    </CustomerLayout>
</template>
