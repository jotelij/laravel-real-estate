<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AgentShow from '@/components/common/AgentShow.vue';
import CustomerLayout from '@/layouts/CustomerLayout.vue';
import guest from '@/routes/guest';
import type { BreadcrumbItem } from '@/types';
import type { PropertyOptions } from '@/types/enums';
import type { AgentProfile } from '@/types/models';

type Props = {
    agent_data: AgentProfile,
    options: PropertyOptions,
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Agents',
        href: guest.properties.index(),
    },
];


</script>

<template>
    <Head title="Agents" />
    <CustomerLayout :breadcrumbs="breadcrumbs">
        <AgentShow :agent_data="props.agent_data" :options="props.options" />
    </CustomerLayout>
</template>
