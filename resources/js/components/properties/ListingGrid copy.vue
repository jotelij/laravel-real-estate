<script setup lang="ts">
import type { Property, PropertyImage } from '@/types/models'
import type { PropertyStatusEnumOption } from '@/types/enums'
import { Link } from '@inertiajs/vue3';
import guest from '@/routes/guest';
import { get_property_image_path } from '@/lib/utils';

const props = defineProps<{
    property:       Property
    view:          'grid' | 'list'
    statusOptions: PropertyStatusEnumOption[]   // ← passed from parent, sourced from controller
}>()

// Find badge config from enum options
function statusBadge(value: number) {
    return props.statusOptions.find(s => s.value === value)
}

function stars(rating: number) {
    return '★★★★★'
}

function stars2(rating: number) {
    return '★'.repeat(Math.floor(rating)) + '☆'.repeat(5 - Math.floor(rating))
}


</script>

<template>
    <Link :href="guest.properties.show(property).url">
    <!-- Grid card -->
    <div
        v-if="view === 'grid'"
        class="rounded-xl border border-border bg-card cursor-pointer hover:border-foreground/30 transition-colors overflow-hidden"
    >
        
        <div class="aspect-4/3 flex items-center justify-center bg-muted text-4xl">
            <img  :alt="property.title" />
            <!-- <img :src="get_property_image_path(property.images)" :alt="property.title" /> -->
        </div>
        <div class="p-3">
            <p class="text-sm font-medium truncate">{{ property.title }}</p>
            <p class="text-xs text-muted-foreground mb-2">
                {{ property.property_type }} ·
                <span class="text-amber-500">{{ stars(property.price) }}</span>
                {{ property.price }}
            </p>
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium">${{ property.price }}</span>
                <span
                    v-if="statusBadge(property.status)?.label"
                    class="text-[11px] px-2 py-0.5 rounded-full font-medium"
                    :class="statusBadge(property.status)?.badgeClass"
                >
                    {{ statusBadge(property.status)?.label }}
                </span>
            </div>
        </div>
    </div>

    <!-- List row -->
    <div
        v-else
        class="flex items-center gap-3 rounded-xl border border-border bg-card px-4 py-2.5 cursor-pointer hover:border-foreground/30 transition-colors"
    >
        <div class="w-12 h-12 rounded-lg bg-muted flex items-center justify-center text-xl shrink-0">
            <img :src="get_property_image_path(property.images)" alt="" class="w-full h-full object-cover rounded-lg" />
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-medium truncate">{{ property.title }}</p>
            <p class="text-xs text-muted-foreground">{{ property.property_type }}</p>
        </div>
        <div class="flex flex-col items-end gap-1 shrink-0">
            <span class="text-sm font-medium">${{ property.price }}</span>
            <div class="flex items-center gap-1.5">
                <span class="text-amber-500 text-[10px]">{{ stars(property.price) }}</span>
                <span class="text-xs text-muted-foreground">{{ property.price }}</span>
                <span
                    v-if="statusBadge(property.status)?.label"
                    class="text-[11px] px-2 py-0.5 rounded-full font-medium"
                    :class="statusBadge(property.status)?.badgeClass"
                >
                    {{ statusBadge(property.status)?.label }}
                </span>
            </div>
        </div>
    </div>
    </Link>
</template>