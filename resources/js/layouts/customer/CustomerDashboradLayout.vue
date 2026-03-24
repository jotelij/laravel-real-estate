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
        <div class="mx-auto max-w-7xl p-4">
            <main class="py-2 lg:py-4 xl:py-6">
                <slot />
            </main>
        </div>
    </AppLayout>
</template>
