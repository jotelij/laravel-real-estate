<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import type { BreadcrumbItem } from '@/types';
import GuestLayout from '@/layouts/GuestLayout.vue';
import guest from '@/routes/guest';
import { Property } from '@/types/models';
import { PropertyOptions } from '@/types/enums';
import PropertyShow from '@/components/common/PropertyShow.vue';
import CustomerLayout from '@/layouts/CustomerLayout.vue';

type Props = {
    property_data: Property,
    options:  PropertyOptions;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Show',
        href: guest.properties.show(props.property_data.id),
    },
];

</script>

<template>
    <Head title="Property" />
    <CustomerLayout :breadcrumbs="breadcrumbs">
        <PropertyShow :property_data="property_data" :options="options" />
    </CustomerLayout>
</template>
