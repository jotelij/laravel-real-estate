<script setup lang="ts">
import CustomerDashboradLayout from './customer/CustomerDashboradLayout.vue';
import CustomerWideLayout from './customer/CustomerWideLayout.vue';
import { CalendarDaysIcon, Home, HouseHeart, HouseHeartIcon, LayoutGrid, MapPinHouseIcon, MessagesSquareIcon } from 'lucide-vue-next';
import customer from '@/routes/customer';
import type { BreadcrumbItem, NavItem } from '@/types';
import type { AppVariant } from '@/types';
import guest from '@/routes/guest';
import { home } from '@/routes';

defineProps<{
    title?: string;
    description?: string;
    is_wide?: boolean;
}>();


const mainNavItems: NavItem[] = [
    {
        title: 'Home',
        href: home(),
        icon: Home,
    },{
        title: 'Properties',
        href: guest.properties.index(),
        icon: MapPinHouseIcon,
    },
    {
        title: 'Dashboard',
        href: customer.dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Favorites',
        href: customer.favourites(),
        icon: HouseHeartIcon,
    },
    {
        title: 'Enquiries',
        href: customer.enquiries.index(),
        icon: MessagesSquareIcon,
    },
    {
        title: 'Viewings',
        href: customer.viewings.index(),
        icon: CalendarDaysIcon,
    },
];
</script>

<template>
    <CustomerWideLayout v-if="is_wide" :mainNavItems="mainNavItems">
        <slot />
    </CustomerWideLayout>
    <CustomerDashboradLayout v-else :mainNavItems="mainNavItems">
        <slot />
    </CustomerDashboradLayout>
</template>
