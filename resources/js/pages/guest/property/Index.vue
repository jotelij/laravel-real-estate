<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PropertyIndex from '@/components/common/PropertyIndex.vue';
import GuestLayout from '@/layouts/GuestLayout.vue';
import type { Paginated } from '@/types';
import type { PropertyOptions } from '@/types/enums';
import type { Property, PropertyFilters } from '@/types/models';

interface Props {
    properties_data: Paginated<Property>;
    filters:  PropertyFilters;
    options:  PropertyOptions;
}

const props = defineProps<Props>(); 


</script>

<template> 
    <Head title="Property Listings" />

    <GuestLayout>
        <PropertyIndex
            :properties_data="props.properties_data"
            :filters="props.filters"
            :options="props.options" />
    </GuestLayout>
</template>
