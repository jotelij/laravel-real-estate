import { router }            from '@inertiajs/vue3'
import { reactive, watch }   from 'vue'
import guest from '@/routes/guest';
import type { PropertyFilters, PropertyTypeRaw, ListingTypeRaw, PropertyStatusRaw } from '@/types/models';

const DEFAULTS: Required<PropertyFilters> = {
    search:     '',
    property_types: [],
    listing_types: [],
    statuses:   [],
    max_price:  500,
    sort:       'default',
}

export function usePropertyFilters(initial: PropertyFilters = {}) {
    const normalizedInitial: PropertyFilters = {
        ...initial,
        property_types: normalizeNumericArray(initial.property_types) as PropertyTypeRaw[],
        listing_types: normalizeNumericArray(initial.listing_types) as ListingTypeRaw[],
        statuses: normalizeNumericArray(initial.statuses) as PropertyStatusRaw[],
        max_price: typeof initial.max_price === 'string' ? Number(initial.max_price) : initial.max_price,
    }

    const filters = reactive<Required<PropertyFilters>>({
        ...DEFAULTS,
        ...normalizedInitial,
    })

    // -------------------------
    // Navigation
    // -------------------------

    let debounceTimer: ReturnType<typeof setTimeout>

    function applyFilters() {
        clearTimeout(debounceTimer)
        debounceTimer = setTimeout(() => {
            router.get(
                guest.properties.index(),
                buildPayload(filters),
                {
                    preserveState:  true,
                    preserveScroll: true,
                    replace:        true,
                }
            )
        }, 300)
    }

    // -------------------------
    // Toggle helpers
    // -------------------------

    function toggleCategory(value: PropertyTypeRaw) {
        toggle(filters.property_types, value)
    }

    function toggleListingType(value: ListingTypeRaw) {
        toggle(filters.listing_types, value)
    }

    function toggleStatus(value: PropertyStatusRaw) {
        toggle(filters.statuses, value)
    }

    function hasCategory(value: PropertyTypeRaw): boolean {
        return filters.property_types.includes(value)
    }

    function hasStatus(value: PropertyStatusRaw): boolean {
        return filters.statuses.includes(value)
    }

    function hasListingType(value: ListingTypeRaw): boolean {
        return filters.listing_types.includes(value)
    }

    // -------------------------
    // Reset
    // -------------------------

    function clearFilters() {
        Object.assign(filters, DEFAULTS)
    }

    function clearSearch() {
        filters.search = DEFAULTS.search
    }

    // -------------------------
    // Watchers
    // -------------------------

    watch(filters, applyFilters, { deep: true })

    // -------------------------
    // Expose
    // -------------------------

    return {
        filters,
        toggleCategory,
        toggleListingType,
        toggleStatus,
        hasCategory,
        hasListingType,
        hasStatus,
        clearFilters,
        clearSearch,
    }
}

// -------------------------
// Pure helpers (non-reactive, easily testable)
// -------------------------

function toggle<T>(list: T[], value: T): void {
    const idx = list.indexOf(value)
    // eslint-disable-next-line @typescript-eslint/no-unused-expressions
    idx === -1 ? list.push(value) : list.splice(idx, 1)
}

// Record<string, unknown> 

function buildPayload(filters: Required<PropertyFilters>): any {
    const payload: Record<string, unknown> = {}

    if (filters.search)                     {
payload.search     = filters.search
}

    if (filters.property_types.length)      {
payload.property_types = filters.property_types
}

    if (filters.listing_types.length)       {
payload.listing_types  = filters.listing_types
}

    if (filters.statuses.length)            {
payload.statuses       = filters.statuses
}

    if (filters.max_price  !== DEFAULTS.max_price)  {
payload.max_price  = filters.max_price
}

    if (filters.sort       !== DEFAULTS.sort)       {
payload.sort       = filters.sort
}

    return payload
}

function normalizeNumericArray(value: unknown): number[] {
    if (!Array.isArray(value)) {
return []
}

    return value
        .map((v) => typeof v === 'string' ? Number(v) : v)
        .filter((v): v is number => typeof v === 'number' && Number.isFinite(v))
}