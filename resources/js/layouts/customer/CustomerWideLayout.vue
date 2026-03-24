<script setup lang="ts">
import type { BreadcrumbItem, NavItem } from '@/types';
import type { AppVariant } from '@/types';
import guest from '@/routes/guest';
import { home } from '@/routes';
import { CalendarDaysIcon, Home, HouseHeart, HouseHeartIcon, LayoutGrid, MapPinHouseIcon, MessagesSquareIcon } from 'lucide-vue-next';
import AppLayout from '../app/AppLayout.vue';
import customer from '@/routes/customer';

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
