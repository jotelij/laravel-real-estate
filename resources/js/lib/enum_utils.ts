import { EnumOption } from "@/types";
import { EnquiryStatusRaw, ListingTypeRaw, PropertyStatusRaw, PropertyTypeRaw } from "@/types/models";


export function getPropertyStatusValue(status_value?: PropertyStatusRaw): EnumOption<PropertyStatusRaw>{
    switch (status_value) {
        case 1:
            return { label: "Active", value: 1, badgeClass: "bg-blue-100 text-green-800" };
        case 2:
            return { label: "Pending", value: 2, badgeClass: "bg-yellow-100 text-yellow-800" };
        case 3:
            return { label: "Sold", value: 3, badgeClass: "bg-green-100 text-green-800" };
        case 4:
            return { label: "Rented", value: 4, badgeClass: "bg-green-100 text-green-800" };
        case 5:
            return { label: "Off Market", value: 5, badgeClass: "bg-muted text-muted-foreground" };
        case 6:
            return { label: "Archived", value: 6, badgeClass: "bg-muted text-muted-foreground" };
        default:
            return { label: "Unknown", value: 0, badgeClass: "bg-gray-100 text-gray-800" };
    }
}

export function getPropertyListingValue(listing_value?: ListingTypeRaw): EnumOption<ListingTypeRaw>{
    switch (listing_value) {
        case 1:
            return { label: "For Sale", value: 1, badgeClass: "bg-blue-100 text-blue-800" };
        case 2:
            return { label: "For Rent", value: 2, badgeClass: "bg-green-100 text-green-800" };
        default:
            return { label: "Unknown", value: 0, badgeClass: "bg-gray-100 text-gray-800" };
    }
}

export function getPropertyTypeValue(type_value?: PropertyTypeRaw): EnumOption<PropertyTypeRaw>{
    switch (type_value) {
        case 1:
            return { label: "House", value: 1, badgeClass: "bg-blue-100 text-blue-800" };
        case 2:
            return { label: "Apartment", value: 2, badgeClass: "bg-indigo-100 text-indigo-800" };
        case 3:
            return { label: "Villa", value: 3, badgeClass: "bg-purple-100 text-purple-800" };
        case 4:
            return { label: "Commercial", value: 4, badgeClass: "bg-yellow-100 text-yellow-800" };
        case 5:
            return { label: "Land", value: 5, badgeClass: "bg-teal-100 text-teal-800" };
        case 6:
        default:
            return { label: "Other", value: 6, badgeClass: "bg-gray-100 text-gray-800" };
    }
}

export function getEnquiryStatusValue(type_value: EnquiryStatusRaw): EnumOption<EnquiryStatusRaw> {
    switch (type_value) {
        case 1:
            return {
                label: "New",
                value: 1,
                badgeClass: "bg-blue-100 text-blue-800"
            };
        case 2:
            return {
                label: "In Progress",
                value: 2,   
                badgeClass: "bg-yellow-100 text-yellow-800"
            };
        case 3:
        default:
            return {
                label: "Resolved",
                value: 3,
                badgeClass: "bg-green-100 text-green-800"
            };
    }
}

export function getViewingsStatusValue(status_value: number): EnumOption<any> {
    switch (status_value) {
        case 1:
            return {
                label: "Requested",
                value: 1,
                badgeClass: "bg-blue-100 text-blue-800"
            };
        case 2:
            return {
                label: "Confirmed",
                value: 2,
                badgeClass: "bg-green-100 text-green-800"
            };
        case 3:
            return {
                label: "Completed",
                value: 3,
                badgeClass: "bg-gray-100 text-gray-800"
            };
        case 4:
            return {
                label: "Cancelled",
                value: 4,
                badgeClass: "bg-red-100 text-red-800"
            };
        default:
            return {
                label: "Unknown",
                value: 0,
                badgeClass: "bg-gray-100 text-gray-800"
            };
    }
}
