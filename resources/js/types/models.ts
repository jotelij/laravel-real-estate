import { getPropertyTypeValue } from "@/lib/enum_utils"
import { User } from "./auth"
import { EnumOption } from "./enums"

export type PropertyTypeRaw = 1 | 2 | 3 | 4 | 5 | 6
export type ListingTypeRaw   = 1 | 2
export type PropertyStatusRaw   =  1 | 2 | 3 | 4 | 5 | 6
export type EnquiryStatusRaw   =  1 | 2 | 3 

const PropertyTypeRawValues: PropertyTypeRaw[] = [1, 2, 3, 4, 5, 6]
const ListingTypeRawValues: ListingTypeRaw[] = [1, 2]
const PropertyStatusRawValues: PropertyStatusRaw[] = [1, 2, 3, 4, 5, 6]
const EnquiryStatusRawValues: EnquiryStatusRaw[] = [1, 2, 3]

export const propertyTypeOptions: EnumOption<PropertyTypeRaw>[] = PropertyTypeRawValues.map(getPropertyTypeValue);
export const propertyListingTypeOptions: EnumOption<ListingTypeRaw>[] = ListingTypeRawValues.map(getPropertyTypeValue);
export const propertyStatusOptions: EnumOption<PropertyStatusRaw>[] = PropertyStatusRawValues.map(getPropertyTypeValue);
export const enquiryStatusOptions: EnumOption<EnquiryStatusRaw>[] = EnquiryStatusRawValues.map(getPropertyTypeValue);

export interface AgentProfile {
    id: number,
    agency_name: string,
    license_number?: number,
    bio?: string,
    est?: number,
    is_approved?: boolean,
    average_rating?: number,
    properties: Property[]
}

export type Amenity = {
    id: number,
    name: string,
    icon?: string
}
export type PropertyAddress = {
    country: string,
    region: string,
    city: string,
    address_line_1: string,
    address_line_2?: string,
    postcode: string,
    latitude: number,
    longitude: number,
    full_address: string
}

export type Country = {
    id: number,
    name: string,
    code: string,
    flag_url?: string
}

export type PropertyImage = {
    id: number
    image_path: string
    is_featured: boolean
}

export type PropertyFilters = {
    search?: string
    property_types?: PropertyTypeRaw[]
    listing_types?: ListingTypeRaw[]
    statuses?: PropertyStatusRaw[]
    max_price?: number
    sort?: string
}
    
export type Property = {
    id: number
    title: string
    slug: string,
    description?: string,
    property_type?: PropertyTypeRaw,
    listing_type?: ListingTypeRaw,
    status: PropertyStatusRaw,
    price: number,
    bedrooms?: number,
    bathrooms?: number,
    garages: number,
    floor_area: number,
    land_area: number,
    year_built: number,
    is_featured: boolean,
    views_count: number,
    virtual_tour_link?: string,
    images?: PropertyImage[]
    agent?: AgentProfile
    amenities?: Amenity[]
    address?: PropertyAddress
}

export type Message = {
    id: number,
    enquiry_id: number,
    sender_id: number,
    body: string,
    created_at: string,
    read_at?: string,
    enquiry?: Enquiry,
    sender?: User
}

export type Enquiry = {
    id: number,
    property_id: number,
    agent_id: number,
    sender_id: number,
    subject: string,
    message: string,
    created_at: string,
    status: EnquiryStatusRaw,
    property?: Property,
    sender?: User,
    agent?: User,
    messages: Message[]
}

export type ViewingsStatus = 1 | 2 | 3 | 4

export type Viewing = {
    id: number,
    property_id: number,
    buyer_id: number,
    agent_id: number,
    scheduled_at: string,
    status: ViewingsStatus,
    notes?: string,
    created_at: string,
    property?: Property,
    agent?: User,
    buyer?: User
}


export type Review = {
    id: number,
    property_id: number,
    user_id: number,
    rating: number,
    comment?: string,
    created_at: string,
    property?: Property,
    user?: User
}