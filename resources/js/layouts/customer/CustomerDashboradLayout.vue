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
        <div class="mx-auto max-w-7xl p-4">
            <main class="py-2 lg:py-4 xl:py-6">
                <slot />
            </main>
        </div>
    </AppLayout>
</template>
