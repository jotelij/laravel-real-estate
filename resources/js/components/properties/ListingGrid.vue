<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { rating_stars } from '@/lib/utils';
import guest from '@/routes/guest';
import type { PropertyStatusEnumOption } from '@/types/enums'
import type { Property } from '@/types/models'
import GridPictures from './GridPictures.vue';

const props = defineProps<{
    property:       Property
    view:          'grid' | 'list'
    statusOptions: PropertyStatusEnumOption[]   // ← passed from parent, sourced from controller
}>()

// Find badge config from enum options
function statusBadge(value: number) {
    return props.statusOptions.find(s => s.value === value)
}
</script>

<template>
    <Link :href="guest.properties.show(property).url">
    <!-- Grid card -->
    <div class="rounded-xl border border-border bg-card cursor-pointer hover:border-foreground/30 transition-colors overflow-hidden">
        
        <div class="aspect-4/3 flex items-center justify-center bg-muted text-4xl">
            <GridPictures :images="property.images!.map(img => img.image_path)" />
        </div>
        <div class="p-3">
            <p class="text-sm font-medium truncate">{{ property.title }}</p>
            <p class="text-xs text-muted-foreground mb-2">
                {{ property.property_type }} ·
                <span class="text-amber-500">{{ rating_stars(5) }}</span>
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
    </Link>
</template>