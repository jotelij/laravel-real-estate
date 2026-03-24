<script setup lang="ts">
import { Home, LayoutGrid } from 'lucide-vue-next';
import { home } from '@/routes';
import guest from '@/routes/guest';
import type { BreadcrumbItem, NavItem } from '@/types';
import type { AppVariant } from '@/types';
import AppLayout from './app/AppLayout.vue';

type Props = {
    breadcrumbs?: BreadcrumbItem[];
    variant?: AppVariant;
};

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
    variant: 'sidebar',
});

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
