<script setup lang="ts">
import type { BreadcrumbItem, NavItem } from '@/types';
import type { AppVariant } from '@/types';
import AppLayout from '../app/AppLayout.vue';

type Props = {
    breadcrumbs?: BreadcrumbItem[];
    variant?: AppVariant;
    mainNavItems?: NavItem[];
};

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
    variant: 'sidebar',
    mainNavItems: () => [],
});

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs" :mainNavItems="mainNavItems">
        <slot />
    </AppLayout>
</template>
