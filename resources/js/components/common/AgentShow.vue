<script setup lang="ts">
import { FacebookIcon, GithubIcon, InstagramIcon, TwitterIcon } from 'lucide-vue-next';
import ListingGrid from '@/components/properties/ListingGrid.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import type { PropertyOptions } from '@/types/enums';
import type { AgentProfile } from '@/types/models';

type Props = {
    agent_data: AgentProfile,
    options: PropertyOptions,
}

const props = defineProps<Props>();

</script>

<template>
    <div class='mx-auto mt-4 max-w-7xl space-y-6 px-4 sm:space-y-8 sm:px-6 lg:space-y-12 lg:px-8'>
        <div class='space-y-4'>
            <h2 class='text-2xl font-semibold sm:text-3xl lg:text-4xl'>
                {{ props.agent_data.agency_name }}
            </h2>
            <div class="flex w-full flex-wrap gap-4">
                <span class='text-2xl font-semibold'>License ID: {{ agent_data.license_number }}</span>
            </div>

            <div class="flex w-full flex-wrap gap-12">
                <span>
                    <Badge variant='default' class='text-sm font-normal'>
                        Since: {{ props.agent_data.est }}
                    </Badge>
                </span>
            </div>
        </div>

        <div class='grid gap-6 lg:grid-cols-3'>
            <div class='columns-1 gap-6 space-y-6 sm:col-span-2 sm:columns-1'>
                <h3 class='text-3xl font-medium'>Properties</h3>

                <div
                    v-if="agent_data.properties.length"
                    class="grid grid-cols-[repeat(auto-fill,minmax(200px,1fr))] gap-3"
                >
                        <ListingGrid
                            v-for="property in agent_data.properties"
                            :key="property.id"
                            :property="property"
                            :view="'grid'"
                            :status-options="options.statuses"
                        />
                    
                </div>
                <div v-else class="text-center py-16 text-sm text-muted-foreground">
                    No properties match your filters.
                </div>
            </div>

            <div class='space-y-6 px-6'>
                <div class='space-y-4'>
                    <h3 class='text-3xl font-medium'>About</h3>

                    <p class='text-muted-foreground'>
                    {{ agent_data.bio }}
                    </p>
                </div>
                
                <Separator />

                <div class='space-y-4'>
                    <h3 class='text-3xl font-medium'>Contact</h3>

                    <div class="gap-x-5 flex items-center">
                        <Button>
                            Contact Now
                        </Button>

                        <Button>
                            Rent Now
                        </Button>

                    </div>
                </div>
                
                
                <Separator />
                    <div class='space-y-4'>
                    <h3 class='text-3xl font-medium'>Ratings</h3>

                    <div class="gap-x-5 flex items-center">
                        <Button>
                            Contact Now
                        </Button>
                    </div>
                    </div>
                
                <Separator />

                <div class='flex items-center gap-8'>
                    <span class='w-21 text-lg font-medium'>Share:</span>
                    <div class='flex gap-2'>
                        <a href='#'>
                        <FacebookIcon class='size-5.5 text-sky-600' />
                        </a>
                        <a href='#'>
                        <InstagramIcon class='text-destructive size-5.5' />
                        </a>
                        <a href='#'>
                        <GithubIcon class ='text-primary size-5.5' />
                        </a>
                        <a href='#'>
                        <TwitterIcon class='size-5.5 text-sky-600' />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
