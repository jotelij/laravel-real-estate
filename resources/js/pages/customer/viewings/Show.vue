<script setup lang="ts">
import CustomerLayout from '@/layouts/CustomerLayout.vue';
import { Viewing } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { ChevronLeft, Calendar, MapPin, User, Building, Clock, FileText } from 'lucide-vue-next';
import { timeAgo, formatDate } from '@/lib/utils';
import { getViewingsStatusValue } from '@/lib/enum_utils';
import viewings from '@/routes/customer/viewings';

interface Props {
  viewing: Viewing;
}

const props = defineProps<Props>();

const statusValue = getViewingsStatusValue(props.viewing.status);

const isFutureViewing = new Date(props.viewing.scheduled_at) > new Date();
const canCancel = [1, 2].includes(props.viewing.status); // REQUESTED or CONFIRMED
const canReschedule = [1, 2].includes(props.viewing.status);

</script>

<template>
    <Head title="Dashboard" />

  <CustomerLayout>
    <div class="flex flex-1 flex-col gap-0 bg-background">
      <!-- Header with back button and title -->
      <div class="border-b bg-background sticky top-0 z-10 shadow-sm">
        <div class="flex items-center gap-4 p-4 md:p-6">
          <Link :href="viewings.index.url()">
            <Button variant="ghost" size="icon" class="h-8 w-8">
              <ChevronLeft class="h-4 w-4" />
            </Button>
          </Link>
          <div class="flex-1">
            <h1 class="text-xl font-bold">{{ viewing.property?.title }}</h1>
            <p class="text-sm text-muted-foreground">
              Scheduled for {{ formatDate(viewing.scheduled_at) }}
            </p>
          </div>
          <Badge :class="`${statusValue.badgeClass} rounded-full px-4 py-2`">
            {{ statusValue.label }}
          </Badge>
        </div>
      </div>

      <!-- Main Content -->
      <div class="flex-1 overflow-y-auto">
        <!-- Key Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 md:p-6 border-b bg-muted/20">
          <!-- Scheduled Date/Time -->
          <div class="space-y-2">
            <div class="flex items-center gap-2">
              <Calendar class="h-4 w-4 text-primary" />
              <label class="text-xs font-semibold text-muted-foreground uppercase">Scheduled Date & Time</label>
            </div>
            <p class="text-sm font-medium ml-6">{{ formatDate(viewing.scheduled_at) }}</p>
          </div>

          <!-- Status -->
          <div class="space-y-2">
            <div class="flex items-center gap-2">
              <Clock class="h-4 w-4 text-primary" />
              <label class="text-xs font-semibold text-muted-foreground uppercase">Status</label>
            </div>
            <div class="ml-6">
              <Badge :class="`${statusValue.badgeClass} rounded-full`">
                {{ statusValue.label }}
              </Badge>
            </div>
          </div>

          <!-- Property Address -->
          <div class="space-y-2">
            <div class="flex items-center gap-2">
              <MapPin class="h-4 w-4 text-primary" />
              <label class="text-xs font-semibold text-muted-foreground uppercase">Location</label>
            </div>
            <div class="ml-6">
              <p class="text-sm font-medium">{{ viewing.property?.address?.full_address }}</p>
              <p class="text-xs text-muted-foreground mt-1">
                {{ viewing.property?.address?.city }}, {{ viewing.property?.address?.region }}
              </p>
            </div>
          </div>

          <!-- Agent Information -->
          <div class="space-y-2">
            <div class="flex items-center gap-2">
              <User class="h-4 w-4 text-primary" />
              <label class="text-xs font-semibold text-muted-foreground uppercase">Agent</label>
            </div>
            <div class="ml-6">
              <p class="text-sm font-medium">{{ viewing.agent?.name }}</p>
              <p class="text-xs text-muted-foreground">{{ viewing.agent?.agent_profile?.agency_name }}</p>
            </div>
          </div>

          <!-- Property Type -->
          <div class="space-y-2">
            <div class="flex items-center gap-2">
              <Building class="h-4 w-4 text-primary" />
              <label class="text-xs font-semibold text-muted-foreground uppercase">Property Type</label>
            </div>
            <p class="text-sm font-medium ml-6">
              {{ viewing.property?.bedrooms }} bed{{ viewing.property?.bedrooms !== 1 ? 's' : '' }} •
              {{ viewing.property?.bathrooms }} bath{{ viewing.property?.bathrooms !== 1 ? 's' : '' }}
            </p>
          </div>

          <!-- Price -->
          <div class="space-y-2">
            <div class="flex items-center gap-2">
              <span class="h-4 w-4 text-primary text-xl">💰</span>
              <label class="text-xs font-semibold text-muted-foreground uppercase">Price</label>
            </div>
            <p class="text-sm font-semibold ml-6 text-primary">${{ viewing.property?.price?.toLocaleString() }}</p>
          </div>

          <!-- Property Details -->
          <div class="space-y-2">
            <div class="flex items-center gap-2">
              <FileText class="h-4 w-4 text-primary" />
              <label class="text-xs font-semibold text-muted-foreground uppercase">Property Size</label>
            </div>
            <p class="text-sm font-medium ml-6">
              {{ viewing.property?.floor_area?.toLocaleString() }} sqft floor •
              {{ viewing.property?.land_area?.toLocaleString() }} sqft land
            </p>
          </div>
        </div>

        <!-- Property Description -->
        <div v-if="viewing.property?.description" class="p-4 md:p-6 border-b">
          <h3 class="text-sm font-semibold uppercase text-muted-foreground mb-3">Property Description</h3>
          <p class="text-sm leading-relaxed text-foreground">{{ viewing.property.description }}</p>
        </div>

        <!-- Viewing Notes -->
        <div v-if="viewing.notes" class="p-4 md:p-6 border-b bg-blue-50 dark:bg-blue-950/20">
          <h3 class="text-sm font-semibold uppercase text-muted-foreground mb-3 flex items-center gap-2">
            <FileText class="h-4 w-4" />
            Notes
          </h3>
          <p class="text-sm leading-relaxed">{{ viewing.notes }}</p>
        </div>

        <!-- Request Information -->
        <div class="p-4 md:p-6 bg-muted/30">
          <p class="text-xs text-muted-foreground">
            Viewing requested <span class="font-semibold">{{ timeAgo(viewing.created_at) }}</span>
          </p>
        </div>
      </div>

      <!-- Action Buttons Footer -->
      <div class="border-t bg-background p-4 md:p-6 flex gap-3 flex-wrap">
        <Link :href="viewings.index.url()">
          <Button variant="outline">
            Back to Viewings
          </Button>
        </Link>

        <Button v-if="canReschedule" variant="secondary" disabled>
          Reschedule
        </Button>

        <Button v-if="canCancel" variant="destructive" disabled>
          Cancel Viewing
        </Button>

        <div class="flex-1" />

        <Button v-if="viewing.status === 2" variant="default" disabled>
          Mark as Completed
        </Button>
      </div>
    </div>
  </CustomerLayout>
</template>
