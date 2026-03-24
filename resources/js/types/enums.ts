import { ListingTypeRaw, PropertyStatusRaw, PropertyTypeRaw, ViewingsStatus } from "./models"

export interface EnumOption<T> {
    value: number
    label: string
    badgeClass?: string
}

export interface PropertyStatusEnumOption extends EnumOption<PropertyStatusRaw> {
    badgeClass: string
}

export interface PropertyOptions {
    property_types: EnumOption<PropertyTypeRaw>[]
    listing_types: EnumOption<ListingTypeRaw>[]
    statuses:   PropertyStatusEnumOption[]
}