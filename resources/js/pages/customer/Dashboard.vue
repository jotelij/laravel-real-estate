<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ArrowRightIcon, TrendingUp } from 'lucide-vue-next';
import DashboardHeader from '@/components/DashboardHeader.vue';
import ListingGrid from '@/components/properties/ListingGrid.vue';
import { Badge } from "@/components/ui/badge"
import {
  Card,
  CardAction,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/components/ui/card"
import Separator from '@/components/ui/separator/Separator.vue';
import AppointmentCard from '@/components/viewings/AppointmentCard.vue';
import CustomerLayout from '@/layouts/CustomerLayout.vue';
import customer from '@/routes/customer';
import type { Enquiry, Property, Viewing } from '@/types';

interface Props {
    user: {
        enquiries_sent_count: number;
        viewings_count: number;
        favourites_count: number;
    },
    favourite_properties: Property[],
    recent_viewings: Viewing[],
    recent_enquiries: Enquiry[]
}

const props = defineProps<Props>();
</script>

<template>
    <Head title="Dashboard" />

    <CustomerLayout>
        <div class="flex flex-1 flex-col gap-4 p-4 pt-0">
            <DashboardHeader title="Dashboard"
                description="Welcome back! Here is an overview of your account and recent activity." />

            <!-- top cards  -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <Card class="@container/card">
                    <CardHeader>
                        <CardDescription>Favourites</CardDescription>
                        <CardTitle class="text-2xl font-semibold tabular-nums @[250px]/card:text-3xl">
                        {{ props.user.favourites_count }}
                        </CardTitle>
                        <CardAction>
                       <Link :href="customer.favourites.url()">
                            <Badge variant="outline">
                                <ArrowRightIcon /> More
                            </Badge>
                        </Link>
                        </CardAction>
                    </CardHeader>
                    <CardFooter class="flex-col items-start gap-1.5 text-sm">
                        <div class="line-clamp-1 flex gap-2 font-medium">
                        Total favourites
                        </div>
                        <div class="text-muted-foreground">
                        Visitors for the last 6 months
                        </div>
                    </CardFooter>
                </Card>

                <Card class="@container/card">
                    <CardHeader>
                        <CardDescription>Enquiries</CardDescription>
                        <CardTitle class="text-2xl font-semibold tabular-nums @[250px]/card:text-3xl">
                        {{ props.user.enquiries_sent_count }}
                        </CardTitle>
                        <CardAction>
                       <Link :href="customer.enquiries.index.url()">
                            <Badge variant="outline">
                                <ArrowRightIcon /> More
                            </Badge>
                        </Link>
                        </CardAction>
                    </CardHeader>
                    <CardFooter class="flex-col items-start gap-1.5 text-sm">
                        <div class="line-clamp-1 flex gap-2 font-medium">
                        Total enquiries sent
                        </div>
                        <div class="text-muted-foreground">
                        Visitors for the last 6 months
                        </div>
                    </CardFooter>
                </Card>
                
                <Card class="@container/card">
                    <CardHeader>
                        <CardDescription>Viewings</CardDescription>
                        <CardTitle class="text-2xl font-semibold tabular-nums @[250px]/card:text-3xl">
                        {{ props.user.viewings_count }}
                        </CardTitle>
                        <CardAction>
                       <Link :href="customer.viewings.index.url()">
                            <Badge variant="outline">
                                <ArrowRightIcon /> More
                            </Badge>
                        </Link>
                        </CardAction>
                    </CardHeader>
                    <CardFooter class="flex-col items-start gap-1.5 text-sm">
                        <div class="line-clamp-1 flex gap-2 font-medium">
                        Total viewings scheduled
                        </div>
                        <div class="text-muted-foreground">
                        Visitors for the last 6 months
                        </div>
                    </CardFooter>
                </Card>

                <Card class="@container/card">
                    <CardHeader>
                        <CardDescription>Total Revenue</CardDescription>
                        <CardTitle class="text-2xl font-semibold tabular-nums @[250px]/card:text-3xl">
                        $1,250.00
                        </CardTitle>
                        <CardAction>
                        <Badge variant="outline">
                            <TrendingUp />
                            +12.5%
                        </Badge>
                        </CardAction>
                    </CardHeader>
                    <CardFooter class="flex-col items-start gap-1.5 text-sm">
                        <div class="line-clamp-1 flex gap-2 font-medium">
                        Trending up this month <TrendingUp class="size-4" />
                        </div>
                        <div class="text-muted-foreground">
                        Visitors for the last 6 months
                        </div>
                    </CardFooter>
                </Card>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-4">
                <!-- // show recent enquiries and viewings here -->
                <div class="rounded-lg border bg-white p-4">
                    <h3 class="mb-4 font-semibold text-gray-900">Favoutries</h3>

                    <!-- List recent favourites here -->
                    <p class="text-sm text-gray-500">You have {{ props.user.favourites_count }} favourite properties.</p>  
                    <Separator class="my-4"/> 
                    <!-- Viewings List -->
                    <!-- Viewings List -->
                    <div  class="space-y-2">
                        <div
                            v-if="props.favourite_properties.length"
                            class="grid grid-cols-[repeat(auto-fill,minmax(150px,1fr))] gap-3"
                            >
                                <ListingGrid
                                    v-for="property in props.favourite_properties"
                                    :key="property.id"
                                    :property="property"
                                    :view="'grid'"
                                    :status-options=[]
                                />
                            
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border bg-white p-4">
                    <h3 class="mb-4 font-semibold text-gray-900">Recent Appointments</h3>
                    <!-- List recent viewings here -->
                    <p class="text-sm text-gray-500">You have received {{ props.user.viewings_count }} appointments recently.</p>  
                    <Separator class="my-4"/> 
                    <!-- Viewings List -->
                    <div  class="space-y-2">
                        <div 
                            v-for="viewing in props.recent_viewings" 
                            :key="viewing.id"
                            class="flex items-start gap-4 rounded-lg border border-gray-200 p-4 hover:border-gray-300 hover:shadow-sm transition-all"
                        >
                        <AppointmentCard :viewing="viewing" :is_for_agent="false"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </CustomerLayout>
</template>