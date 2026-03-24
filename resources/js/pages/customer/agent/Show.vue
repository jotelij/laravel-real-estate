<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import type { BreadcrumbItem } from '@/types';
import GuestLayout from '@/layouts/GuestLayout.vue';
import guest from '@/routes/guest';
import { AgentProfile } from '@/types/models';
import { Badge } from '@/components/ui/badge';
import { FacebookIcon, GithubIcon, InstagramIcon, TwitterIcon } from 'lucide-vue-next';
import { Separator } from '@/components/ui/separator';
import { Button } from '@/components/ui/button';
import { PropertyOptions } from '@/types/enums';
import ListingGrid from '@/components/properties/ListingGrid.vue';
import AgentShow from '@/components/common/AgentShow.vue';
import CustomerLayout from '@/layouts/CustomerLayout.vue';

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
        <AgentShow :agent_data="agent_data" :options="options" />
    </CustomerLayout>
</template>
