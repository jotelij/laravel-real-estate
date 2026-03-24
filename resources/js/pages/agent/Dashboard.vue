<script setup lang="ts">
import DashboardHeader from '@/components/DashboardHeader.vue';
import { Badge } from "@/components/ui/badge"
import AgentLayout from '@/layouts/AgentLayout.vue';
import {
  Card,
  CardAction,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/components/ui/card"
import agent from '@/routes/agent';
import { ArrowRightIcon, TrendingUp } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';
import Separator from '@/components/ui/separator/Separator.vue';
import { Enquiry, Viewing } from '@/types';
import AppointmentCard from '@/components/viewings/AppointmentCard.vue';
import EnquiryTable from '@/components/enquiry/EnquiryTable.vue';


interface Props {
  user: {
    enquiries_received_count: number;
    agent_viewings_count: number;
    properties_count: number;
  },
    agent_viewings: Viewing[], 
    recent_enquiries: Enquiry[]

}

const props = defineProps<Props>();
</script>

<template>
    <AgentLayout>
        <div class="flex flex-1 flex-col gap-4 p-4 pt-0">
            <DashboardHeader title="Agent Dashboard"
                description="Welcome back! Here is an overview of your account and recent activity." />

            
            <!-- top cards  -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <Card class="@container/card">
                    <CardHeader>
                        <CardDescription>Properties</CardDescription>
                        <CardTitle class="text-2xl font-semibold tabular-nums @[250px]/card:text-3xl">
                        {{ props.user.properties_count }}
                        </CardTitle>
                        <CardAction>
                       <Link :href="agent.properties.index.url()">
                            <Badge variant="outline">
                                <ArrowRightIcon /> More
                            </Badge>
                        </Link>
                        </CardAction>
                    </CardHeader>

                    <CardFooter class="flex-col items-start gap-1.5 text-sm">
                        <div class="line-clamp-1 flex gap-2 font-medium">
                        Total properties listed
                        </div>
                        <div class="text-muted-foreground">
                        View in detail by clicking more
                        </div>
                    </CardFooter>
                </Card>

                <Card class="@container/card">
                    <CardHeader>
                        <CardDescription>Enquiries</CardDescription>
                        <CardTitle class="text-2xl font-semibold tabular-nums @[250px]/card:text-3xl">
                        {{ props.user.enquiries_received_count }}
                        </CardTitle>
                        <CardAction>
                       <Link :href="agent.enquiries.index.url()">
                            <Badge variant="outline">
                                <ArrowRightIcon /> More
                            </Badge>
                        </Link>
                        </CardAction>
                    </CardHeader>

                    <CardFooter class="flex-col items-start gap-1.5 text-sm">
                        <div class="line-clamp-1 flex gap-2 font-medium">
                        Total enquiries received
                        </div>
                        <div class="text-muted-foreground">
                        View in detail by clicking more
                        </div>
                    </CardFooter>
                </Card>
                
                <Card class="@container/card">
                    <CardHeader>
                        <CardDescription>Viewings</CardDescription>
                        <CardTitle class="text-2xl font-semibold tabular-nums @[250px]/card:text-3xl">
                        {{ props.user.agent_viewings_count }}
                        </CardTitle>
                        <CardAction>
                       <Link :href="agent.viewings.index.url()">
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
                        View in detail by clicking more
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

            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-4 my-4">
                <!-- // show recent enquiries and viewings here -->
                <div class="rounded-lg border bg-white p-4">
                    <h3 class="mb-4 font-semibold text-gray-900">Recent Appointments</h3>
                    <!-- List recent enquiries here -->
                    <p class="text-sm text-gray-500">You have received {{ props.user.enquiries_received_count }} enquiries recently.</p>  
                    <Separator class="my-4"/> 
                    <!-- Viewings List -->
                    <!-- Viewings List -->
                    <div  class="space-y-2">
                        <div 
                            v-for="viewing in props.agent_viewings" 
                            :key="viewing.id"
                            class="flex items-start gap-4 rounded-lg border border-gray-200 p-4 hover:border-gray-300 hover:shadow-sm transition-all"
                        >
                        <AppointmentCard :viewing="viewing" :is_for_agent="true" />
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border bg-white p-4">
                    <h3 class="mb-4 font-semibold text-gray-900">Recent Enquiries</h3>
                    <!-- List recent enquiries here -->
                    <p class="text-sm text-gray-500">You have received {{ props.user.enquiries_received_count }} enquiries recently.</p>  
                    <Separator class="my-4"/> 

                    <!-- Viewings List -->
                    <!-- Viewings List -->
                    <div  class="space-y-2 ">
                        <EnquiryTable :enquiries="props.recent_enquiries" />
                    </div>
                </div>
            </div>
            
        </div>
    </AgentLayout>
</template>