<!-- eslint-disable vue/no-mutating-props -->
<!-- eslint-disable @typescript-eslint/no-unused-expressions -->

<script setup lang="ts">
import type { PropertyOptions } from '@/types/enums'
import type { PropertyFilters } from '@/types/models'
import { Button } from '../ui/button';
import { Checkbox } from '../ui/checkbox';

const props = defineProps<{
    filters:  PropertyFilters
    options:  PropertyOptions   // ← from controller, no hardcoding
}>()

const emit = defineEmits<{ clear: [] }>()

function togglePropertyType(value: number) {
    const list = (props.filters.property_types ??= [] as any)
    const idx  = list.indexOf(value as any)
    idx === -1 ? list.push(value as any) : list.splice(idx, 1)
}


function toggleListingType(value: number) {
    const list = (props.filters.listing_types ??= [] as any)
    const idx  = list.indexOf(value as any)
    idx === -1 ? list.push(value as any) : list.splice(idx, 1)
}

function toggleStatus(value: number) {
    const list = (props.filters.statuses ??= [] as any)
    const idx  = list.indexOf(value as any)
    idx === -1 ? list.push(value as any) : list.splice(idx, 1)
}
</script>

<template>
    <aside class="w-60 shrink-0 border-r border-border bg-muted/40 p-4 flex flex-col gap-5">
        <p class="text-xs font-medium uppercase tracking-widest text-muted-foreground">
            Filters
        </p>

        <!-- Categories — driven by PHP enum -->
        <div class="flex flex-col gap-2">
            <p class="text-sm font-medium">Property type</p>
            <label
                v-for="opt in options.property_types"
                :key="opt.value"
                class="flex items-center gap-2 cursor-pointer text-sm py-1 px-1.5 rounded-md hover:bg-background"
            >
                <Checkbox
                    :checked="(filters.property_types ?? []).includes(opt.value as any)"
                    @update:checked="togglePropertyType(opt.value)"
                />
                {{ opt.label }}
            </label>
        </div>

        
        <!-- Categories — driven by PHP enum -->
        <div class="flex flex-col gap-2">
            <p class="text-sm font-medium">Listing type</p>
            <label
                v-for="opt in options.listing_types"
                :key="opt.value"
                class="flex items-center gap-2 cursor-pointer text-sm py-1 px-1.5 rounded-md hover:bg-background"
            >
                <Checkbox
                    :checked="(filters.listing_types ?? []).includes(opt.value as any)"
                    @update:checked="toggleListingType(opt.value)"
                />
                {{ opt.label }}
            </label>
        </div>

        <!-- Statuses — driven by PHP enum -->
        <div class="flex flex-col gap-2">
            <p class="text-sm font-medium">Status</p>
            <label
                v-for="opt in options.statuses"
                :key="opt.value"
                class="flex items-center gap-2 cursor-pointer text-sm py-1 px-1.5 rounded-md hover:bg-background"
            >
                <Checkbox
                    :checked="(filters.statuses ?? []).includes(opt.value as any)"
                    @update:checked="toggleStatus(opt.value)"
                />
                {{ opt.label }}
            </label>
        </div>

        <!-- Price -->
        <div class="flex flex-col gap-2">
            <p class="text-sm font-medium">Max price</p>
            <input
                type="range" min="0" max="500" step="10"
                v-model.number="filters.max_price as number"
                class="w-full accent-primary"
            />
            <div class="flex justify-between text-xs text-muted-foreground">
                <span>$0</span>
                <span>up to ${{ filters.max_price }}</span>
            </div>
        </div>

        <Button variant="outline" size="sm" class="mt-auto w-full" @click="emit('clear')">
            Clear all filters
        </Button>
    </aside>
</template>