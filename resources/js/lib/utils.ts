import type { InertiaLinkProps } from '@inertiajs/vue3';
import type { Updater } from '@tanstack/vue-table';
import { clsx } from 'clsx';
import type { ClassValue } from 'clsx';
import { CheckCircle2, Clock4, XCircle } from 'lucide-vue-next';
import { twMerge } from 'tailwind-merge';
import type { PropertyImage } from '@/types';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function valueUpdater<T extends Updater<any>>(updaterOrValue: T | ((oldValue: T) => T), refValue: { value: T }) {
    if (typeof updaterOrValue === 'function') {
        refValue.value = (updaterOrValue as (oldValue: T) => T)(refValue.value);
    } else {
        refValue.value = updaterOrValue;
    }
}

export function valueUpdater2<T extends Updater<any>>(updaterOrValue: T | ((oldValue: T) => T), refValue: { value: T }) {
    if (typeof updaterOrValue === 'function') {
        refValue.value = (updaterOrValue as (oldValue: T) => T)(refValue.value);
    } else {
        refValue.value = updaterOrValue;
    }
}

export function toUrl(href: NonNullable<InertiaLinkProps['href']>) {
    return typeof href === 'string' ? href : href?.url;
}

export function get_property_image_path(images?: PropertyImage[]){
    if(images == null || images.length == 0){
        return "aaaa";
    }

    for (let index = 0; index < images.length; index++) {
        if(images[index].is_featured){
            return images[index].image_path;
        }
    }

    return images[0].image_path;
}


export function rating_stars(rating: number) {
    return '★'.repeat(Math.floor(rating)) + '☆'.repeat(5 - Math.floor(rating))
}


export function timeAgo(dateString: string): string {
  const date = new Date(dateString);
  const now = new Date();
  const seconds = Math.floor((now.getTime() - date.getTime()) / 1000);

  if (isNaN(seconds)) {
return "Invalid date";
}

  const intervals: [number, string][] = [
    [31536000, "year"],
    [2592000, "month"],
    [604800, "week"],
    [86400, "day"],
    [3600, "hour"],
    [60, "minute"],
    [1, "second"],
  ];

  if (seconds < 0) {
    const absSeconds = Math.abs(seconds);

    for (const [interval, label] of intervals) {
      const count = Math.floor(absSeconds / interval);

      if (count >= 1) {
return `in ${count} ${label}${count > 1 ? "s" : ""}`;
}
    }

    return "just now";
  }

  for (const [interval, label] of intervals) {
    const count = Math.floor(seconds / interval);

    if (count >= 1) {
return `${count} ${label}${count > 1 ? "s" : ""} ago`;
}
  }

  return "just now";
}

export function formatDate(dateString: string): string {
  const date = new Date(dateString);

  if (isNaN(date.getTime())) {
return "Invalid date";
}
  
  return date.toLocaleDateString('en-US', {
    month: 'short',
    day: 'numeric',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  });
}

// Format dates for display
export const formatDateShort = (dateString: string) => {
  const date = new Date(dateString)

  return date.toLocaleDateString('en-US', { 
    weekday: 'long', 
    year: 'numeric', 
    month: 'long', 
    day: 'numeric' 
  })
}

export const formatTime = (dateTimeString: string) => {
  const date = new Date(dateTimeString)

  return date.toLocaleTimeString('en-US', { 
    hour: '2-digit', 
    minute: '2-digit',
    hour12: true 
  })
}


// Status badge styling
export const getStatusBadgeConfig = (status: number) => {
  const statusMap: Record<number, { label: string; variant: string; color: string; icon: any }> = {
    1: { label: 'Requested', variant: 'destructive', color: 'bg-blue-50 text-blue-800 border-blue-200', icon: Clock4 },
    2: { label: 'Confirmed', variant: 'default', color: 'bg-green-50 text-green-800 border-green-200', icon: CheckCircle2 },
    3: { label: 'Completed', variant: 'outline', color: 'bg-gray-50 text-gray-800 border-gray-200', icon: CheckCircle2 },
    4: { label: 'Cancelled', variant: 'destructive', color: 'bg-red-50 text-red-800 border-red-200', icon: XCircle },
  }

  return statusMap[status] || statusMap[1]
}
