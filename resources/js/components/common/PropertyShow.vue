<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { FacebookIcon, GithubIcon, InstagramIcon, TwitterIcon } from 'lucide-vue-next';
import EnumBadge from '@/components/EnumBadge.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {  Card, CardContent,  } from '@/components/ui/card';
import { Separator } from '@/components/ui/separator';
import { getPropertyListingValue, getPropertyStatusValue, getPropertyTypeValue } from '@/lib/enum_utils';
import { rating_stars } from '@/lib/utils';
import guest from '@/routes/guest';
import type { PropertyOptions } from '@/types/enums';
import type { Property } from '@/types/models';

type Props = {
    property_data: Property,
    options:  PropertyOptions;
}

const props = defineProps<Props>();

const imgggg = "https://cdn.shadcnstudio.com/ss-assets/blocks/marketing/gallery/image-10.png";
</script>

<template>
    <div class='mx-auto mt-4 max-w-7xl space-y-6 px-4 sm:space-y-8 sm:px-6 lg:space-y-12 lg:px-8'>
        <div class='grid gap-6 md:grid-cols-3 lg:grid-cols-4'>
            <img :src="imgggg" alt="Property Image" class='rounded-lg object-cover' />
            <img :src="imgggg" alt="Property Image" class='rounded-lg object-cover' />
            <img :src="imgggg" alt="Property Image" class='rounded-lg object-cover' />
            <img :src="imgggg" alt="Property Image" class='rounded-lg object-cover' />
        </div>
        
        <div class='grid gap-6 lg:grid-cols-3'>
            <div class='columns-1 gap-6 space-y-6 sm:col-span-2 sm:columns-1'>
                <div class='grid gap-6 lg:grid-cols-3'>
                    <div class="columns-1 space-y-4 sm:col-span-2 sm:columns-1">
                        <h2 class='text-2xl font-semibold sm:text-3xl lg:text-4xl'>
                            {{ props.property_data.title }}
                        </h2>
                        <h3 class='text-lg font-medium text-muted-foreground'>
                            {{ props.property_data.address?.full_address }}
                        </h3>
                    </div>
                    
                    <div class="grid">
                        <div>
                            <span class='text-2xl font-semibold'>${{ props.property_data.price }}</span>
                        </div>

                        <div class="flex w-full flex-wrap gap-x-2">
                            <EnumBadge :enumOption="getPropertyTypeValue(props.property_data.property_type )" />
                            <EnumBadge :enumOption="getPropertyStatusValue(props.property_data.status )" />
                            <EnumBadge :enumOption="getPropertyListingValue(props.property_data.listing_type)" />
                        </div>
                    </div>
                </div>
                
                <Separator />
                <div class='space-y-4'>
                    <h3 class='text-2xl font-medium'>About</h3>
                    <p class='text-muted-foreground'>
                    {{ props.property_data.description }}
                    </p>
                </div>

                <Separator />
                <div class='gap-6 sm:col-span-2 sm:columns-2'>
                    <ul class='space-y-4'>
                        <li class='flex items-center gap-8'>
                            <span class='w-21 text-lg font-medium'>Bedrooms:</span>
                            <span class='text-muted-foreground'>{{ props.property_data.bedrooms }}</span>
                        </li>
                        <li class='flex items-center gap-8'>
                            <span class='w-21 text-lg font-medium'>Bathrooms:</span>
                            <span class='text-muted-foreground'>{{ props.property_data.bathrooms }}</span>
                        </li>
                        <li class='flex items-center gap-8'>
                            <span class='w-21 text-lg font-medium'>Floor Area:</span>
                            <span class='text-muted-foreground'>{{ props.property_data.floor_area }}</span>
                        </li>
                        <li class='flex items-center gap-8'>
                            <span class='w-21 text-lg font-medium'>Land Area:</span>
                            <span class='text-muted-foreground'>{{ props.property_data.land_area }}</span>
                        </li>
                        <li class='flex items-center gap-8'>
                            <span class='w-21 text-lg font-medium'>Year Built:</span>
                            <span class='text-muted-foreground'>{{ props.property_data.year_built }}</span>
                        </li>
                    </ul>
                </div>
            
            </div>

            <div class='space-y-6 px-6 lg:px-8'>
                <div class='space-y-4'>
                    <h3 class='text-2xl font-medium'>Agent Information</h3>
                    <Link v-if="props.property_data.agent != null" :href="guest.agents.show(props.property_data.agent.id).url">
                        <Card>
                            <CardContent>
                                <h3 class='font-medium'> {{ props.property_data.agent?.agency_name ?? "" }}</h3>
                                {{ rating_stars(props.property_data.agent?.average_rating ?? 0) }}
                                <br />
                                <Button variant='secondary'>
                                    View Agent
                                </Button>
                            </CardContent>
                        </Card>
                    </Link>
                </div>

                <Separator />

                    <div class='space-y-4'>
                    <h3 class='text-2xl font-medium'>Amenities</h3>
                    <div class="space-4 flex flex-wrap gap-2">
                        <Badge 
                            v-for="amenity in props.property_data.amenities"
                            :key="amenity.id" 
                            variant="secondary" 
                            class='text-sm'>
                            {{ amenity.name }}
                        </Badge>
                    </div>
                </div>
                <Separator />
                
                <div class="gap-x-5 flex items-center">
                    <Button variant='default'>
                        Rent Now
                    </Button>

                    <Button variant='default'>
                        Contact Now
                    </Button>
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
