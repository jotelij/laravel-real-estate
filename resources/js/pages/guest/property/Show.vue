<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PropertyShow from '@/components/common/PropertyShow.vue';
import GuestLayout from '@/layouts/GuestLayout.vue';
import guest from '@/routes/guest';
import type { BreadcrumbItem } from '@/types';
import type { PropertyOptions } from '@/types/enums';
import type { Property } from '@/types/models';

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
    <GuestLayout :breadcrumbs="breadcrumbs">
        <PropertyShow :property_data="props.property_data" :options="props.options" />
    </GuestLayout>
</template>
