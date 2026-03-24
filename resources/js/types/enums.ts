import type { ListingTypeRaw, PropertyStatusRaw, PropertyTypeRaw} from "./models";
export interface EnumOption<T> {
    value: number
    label: string
    badgeClass?: string,
    modelType?: T
}

export interface PropertyStatusEnumOption extends EnumOption<PropertyStatusRaw> {
    badgeClass: string
}

export interface PropertyOptions {
    property_types: EnumOption<PropertyTypeRaw>[]
    listing_types: EnumOption<ListingTypeRaw>[]
    statuses:   PropertyStatusEnumOption[]
}