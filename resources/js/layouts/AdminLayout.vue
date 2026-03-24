<script setup lang="ts">
import {
    SidebarInset,
    SidebarProvider,
    SidebarTrigger,
} from '@/components/ui/sidebar';
import AppSidebar from '@/components/AppSidebar.vue';
import { Separator } from '@/components/ui/separator';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <SidebarProvider>
        <AppSidebar />
        <SidebarInset>
            <header
                class="flex h-16 shrink-0 items-center gap-2 transition-[width,height] ease-linear group-has-[[data-collapsible=icon]]/sidebar-wrapper:h-12">
                <div class="flex items-center gap-2 px-4">
                    <SidebarTrigger class="-ml-1" />
                </div>
            </header>
            <Separator />
            <main class="px-2 lg:px-4 xl:px-6 py-2 lg:py-4 xl:py-6">
                <slot />
            </main>
        </SidebarInset>
    </SidebarProvider>
</template>
