<script setup lang="ts">
import AppFooter from '@/components/AppFooter.vue';
import AppHeader from '@/components/AppHeader.vue';
import CustomerSidebar from '@/components/CustomerSideBar.vue';
import { Separator } from '@/components/ui/separator';
import {
    SidebarInset,
    SidebarProvider,
} from '@/components/ui/sidebar';

defineProps<{
    title?: string;
    description?: string;
}>();

</script>

<template>
    <SidebarProvider>
        <CustomerSidebar />
        <SidebarInset>
            <AppHeader />
            <Separator />
            <main class="px-2 lg:px-4 xl:px-6 py-2 lg:py-4 xl:py-6">
                <slot />
            </main>
            <AppFooter />
        </SidebarInset>
    </SidebarProvider>
</template>
