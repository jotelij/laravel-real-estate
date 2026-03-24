<script setup lang="ts">
import type { BreadcrumbItem, NavItem } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { SidebarProvider } from '@/components/ui/sidebar';
import type { AppVariant } from '@/types';
import AppLayout from './app/AppLayout.vue';
import guest from '@/routes/guest';
import { home } from '@/routes';
import { Home, LayoutGrid } from 'lucide-vue-next';

type Props = {
    breadcrumbs?: BreadcrumbItem[];
    variant?: AppVariant;
};

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
    variant: 'sidebar',
});

const isOpen = usePage().props.sidebarOpen;


const mainNavItems: NavItem[] = [
    {
        title: 'Home',
        href: home(),
        icon: Home,
    },
    {
        title: 'Properties',
        href: guest.properties.index(),
        icon: LayoutGrid,
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs" :mainNavItems="mainNavItems">
        <slot />
    </AppLayout>
</template>
