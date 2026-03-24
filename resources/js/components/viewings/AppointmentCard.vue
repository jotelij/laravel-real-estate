<script setup lang="ts">
import { Clock, MapPin, User } from 'lucide-vue-next';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { formatDateShort, getStatusBadgeConfig } from '@/lib/utils';
import type { Viewing } from '@/types';


interface Props {
    viewing: Viewing;
    is_for_agent?: boolean;
}

const props = defineProps<Props>();
</script>
<template>
   
        <!-- Time -->
        <div class="flex min-w-16 flex-col items-center">
        <Clock class="mb-2 h-5 w-5 text-blue-600" />
        <span class="text-sm font-semibold text-gray-900">
            {{ formatDateShort(viewing.scheduled_at) }}
        </span>
        </div>

        <!-- Viewing Details -->
        <div class="flex-1">
        <!-- Property -->
        <div class="mb-2">
            <div class="flex items-start gap-2">
            <MapPin class="mt-0.5 h-4 w-4 flex-shrink-0 text-gray-400" />
            <div>
                <h4 class="font-semibold text-gray-900">{{ viewing.property!.title }}</h4>
                <p class="text-xs text-gray-500">{{ viewing.property!.address?.full_address }}</p>
            </div>
            </div>
        </div>

        <!-- Buyer -->
        <div class="mb-3 flex items-center gap-2">
            <User class="h-4 w-4 text-gray-400" />
            <span class="text-sm text-gray-700">{{ props.is_for_agent ? viewing.buyer!.name : viewing.agent!.name }}</span>
        </div>

        <!-- Notes if present -->
        <div v-if="viewing.notes" class="mb-3">
            <p class="text-xs text-gray-600 italic">{{ viewing.notes }}</p>
        </div>
        </div>

        <!-- Status Badge -->
        <div class="flex flex-col items-end gap-2">
        <Badge 
            :class="getStatusBadgeConfig(viewing.status).color"
        >
            {{ getStatusBadgeConfig(viewing.status).label }}
        </Badge>
        <Button 
            variant="outline" 
            size="sm"
            class="text-xs"
        >
            Actions
        </Button>
        </div>
    
</template>