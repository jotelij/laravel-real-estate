<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3'
import { ArrowLeft, ArrowRight, Check } from 'lucide-vue-next'
import { ref, computed } from 'vue'
import DashboardHeader from '@/components/DashboardHeader.vue'
import { Button } from '@/components/ui/button'
import { Checkbox } from '@/components/ui/checkbox'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { NativeSelect } from '@/components/ui/native-select'
import { Textarea } from '@/components/ui/textarea'
import AgentLayout from '@/layouts/AgentLayout.vue'
import properties from '@/routes/agent/properties'
import { propertyListingTypeOptions, propertyTypeOptions } from '@/types/models'
import type { Country, Amenity, PropertyTypeRaw, ListingTypeRaw} from '@/types/models';

interface Props {
  countries: Country[]
  amenities?: Amenity[]
}

const props = defineProps<Props>()

const STEPS = ['Basics', 'Details', 'Location', 'Amenities']

const form = useForm({
  title: '',
  description: '',
  price: 0,
  property_type: 1 as PropertyTypeRaw,
  listing_type: 1 as ListingTypeRaw,
  bedrooms: 0,
  bathrooms: 0,
  garages: 0,
  floor_area: 0,
  land_area: 0,
  year_built: new Date().getFullYear(),
  is_featured: false,
  country_id: null as number | null,
  city: '',
  address_line_1: '',
  address_line_2: '',
  amenities: [] as number[],
})

const currentStep = ref(0)

const canProceedToNextStep = computed(() => {
  switch (currentStep.value) {
    case 0: // Basics
      return form.title.trim() !== '' && form.price > 0
    case 1: // Details
      return form.bedrooms >= 0 && form.year_built
    case 2: // Location
      return form.country_id && form.city.trim() !== '' && form.address_line_1.trim() !== ''
    case 3: // Amenities - no validation required
      return true
    default:
      return false
  }
})

const nextStep = () => {
  if (canProceedToNextStep.value && currentStep.value < STEPS.length - 1) {
    currentStep.value++
  }
}

const prevStep = () => {
  if (currentStep.value > 0) {
    currentStep.value--
  }
}

const toggleAmenity = (amenityId: number) => {
  const index = form.amenities.indexOf(amenityId)

  if (index > -1) {
    form.amenities.splice(index, 1)
  } else {
    form.amenities.push(amenityId)
  }
}

const submitForm = () => {
  
  form.post('/agent/properties', {
    onSuccess: () => {
      form.reset()
      currentStep.value = 0
    },
    onError: () => {
    },
  })
}
</script>

<template>
  <AgentLayout>
    <div class="flex flex-1 flex-col gap-6 p-4 pt-0 max-w-4xl">
      <!-- Header -->
      <div class="flex items-center justify-between">
        <DashboardHeader title="Add New Property" description="Create a new property listing" />
        <Link
          :href="properties.index.url()"
          class="inline-flex items-center justify-center rounded-md bg-muted px-4 py-2 text-sm font-medium transition-colors hover:bg-muted/80"
        >
          <ArrowLeft class="mr-2 h-4 w-4" /> Go back
        </Link>
      </div>

      <!-- Step Indicator -->
      <div class="flex items-center justify-between gap-2">
        <div
          v-for="(step, index) in STEPS"
          :key="step"
          class="flex items-center"
        >
          <div
            :class="[
              'flex h-10 w-10 items-center justify-center rounded-full text-sm font-semibold transition-colors',
              index === currentStep
                ? 'bg-primary text-primary-foreground'
                : index < currentStep
                  ? 'bg-green-500 text-white'
                  : 'bg-muted text-muted-foreground',
            ]"
          >
            <span v-if="index < currentStep">
              <Check class="h-5 w-5" />
            </span>
            <span v-else>{{ index + 1 }}</span>
          </div>
          <span
            :class="[
              'ml-2 text-sm font-medium',
              index === currentStep ? 'text-primary' : 'text-muted-foreground',
            ]"
          >
            {{ step }}
          </span>
          <div
            v-if="index < STEPS.length - 1"
            :class="[
              'mx-2 h-0.5 w-12',
              index < currentStep ? 'bg-green-500' : 'bg-muted',
            ]"
          />
        </div>
      </div>

      <!-- Form Container -->
      <div class="rounded-lg border bg-card p-8">
        <!-- Step 1: Basics -->
        <div v-show="currentStep === 0" class="space-y-6">
          <h3 class="text-lg font-semibold">Property Basics</h3>
          <p class="text-sm text-muted-foreground">
            Tell us about the basic information of your property
          </p>

          <!-- Title -->
          <div>
            <Label for="title" class="mb-2 block">Property Title *</Label>
            <Input
              id="title"
              v-model="form.title"
              type="text"
              placeholder="e.g., Beautiful 3-Bedroom House in Downtown"
            />
            <p v-if="form.errors.title" class="mt-1 text-sm text-destructive">
              {{ form.errors.title }}
            </p>
          </div>

          <!-- Description -->
          <div>
            <Label for="description" class="mb-2 block">Description</Label>
            <Textarea
              id="description"
              v-model="form.description"
              placeholder="Describe your property in detail..."
              :rows="4"
            />
            <p v-if="form.errors.description" class="mt-1 text-sm text-destructive">
              {{ form.errors.description }}
            </p>
          </div>

          <!-- Price -->
          <div>
            <Label for="price" class="mb-2 block">Price ($) *</Label>
            <Input
              id="price"
              v-model.number="form.price"
              type="number"
              step="1000"
              placeholder="0"
            />
            <p v-if="form.errors.price" class="mt-1 text-sm text-destructive">
              {{ form.errors.price }}
            </p>
          </div>

          <!-- Property Type & Listing Type Row -->
          <div class="grid grid-cols-2 gap-4">
            <div>
              <Label for="property_type" class="mb-2 block">Property Type</Label>
              <NativeSelect v-model="form.property_type" id="property_type">
                <option v-for="type in propertyTypeOptions" :key="type.value" :value="type.value">
                  {{ type.label }}
                </option>
              </NativeSelect>
            </div>
            <div>
              <Label for="listing_type" class="mb-2 block">Listing Type</Label>
              <NativeSelect v-model="form.listing_type" id="listing_type">
                <option v-for="type in propertyListingTypeOptions" :key="type.value" :value="type.value">
                  {{ type.label }}
                </option>
              </NativeSelect>
            </div>
          </div>

          <!-- Featured -->
          <div class="flex items-center gap-3">
            <Checkbox
              id="is_featured"
              v-model:checked="form.is_featured"
              class="h-4 w-4"
            />
            <Label for="is_featured" class="font-normal cursor-pointer">
              Feature this property (appears at the top of listings)
            </Label>
          </div>
        </div>

        <!-- Step 2: Details -->
        <div v-show="currentStep === 1" class="space-y-6">
          <h3 class="text-lg font-semibold">Property Details</h3>
          <p class="text-sm text-muted-foreground">
            Provide specific details about your property
          </p>

          <!-- Bedrooms, Bathrooms, Garages Row -->
          <div class="grid grid-cols-3 gap-4">
            <div>
              <Label for="bedrooms" class="mb-2 block">Bedrooms</Label>
              <Input
                id="bedrooms"
                v-model.number="form.bedrooms"
                type="number"
                min="0"
                placeholder="0"
              />
            </div>
            <div>
              <Label for="bathrooms" class="mb-2 block">Bathrooms</Label>
              <Input
                id="bathrooms"
                v-model.number="form.bathrooms"
                type="number"
                min="0"
                placeholder="0"
              />
            </div>
            <div>
              <Label for="garages" class="mb-2 block">Garages</Label>
              <Input
                id="garages"
                v-model.number="form.garages"
                type="number"
                min="0"
                placeholder="0"
              />
            </div>
          </div>

          <!-- Floor Area & Land Area Row -->
          <div class="grid grid-cols-2 gap-4">
            <div>
              <Label for="floor_area" class="mb-2 block">Floor Area (sqft)</Label>
              <Input
                id="floor_area"
                v-model.number="form.floor_area"
                type="number"
                step="100"
                placeholder="0"
              />
            </div>
            <div>
              <Label for="land_area" class="mb-2 block">Land Area (sqft)</Label>
              <Input
                id="land_area"
                v-model.number="form.land_area"
                type="number"
                step="100"
                placeholder="0"
              />
            </div>
          </div>

          <!-- Year Built -->
          <div>
            <Label for="year_built" class="mb-2 block">Year Built *</Label>
            <Input
              id="year_built"
              v-model.number="form.year_built"
              type="number"
              min="1900"
              :max="new Date().getFullYear()"
              placeholder="2024"
            />
            <p v-if="form.errors.year_built" class="mt-1 text-sm text-destructive">
              {{ form.errors.year_built }}
            </p>
          </div>
        </div>

        <!-- Step 3: Location -->
        <div v-show="currentStep === 2" class="space-y-6">
          <h3 class="text-lg font-semibold">Location Details</h3>
          <p class="text-sm text-muted-foreground">
            Where is your property located?
          </p>

          <!-- Country -->
          <div>
            <Label for="country_id" class="mb-2 block">Country *</Label>
            <NativeSelect v-model.number="form.country_id" id="country_id">
              <option :value="null">Select a country...</option>
              <option v-for="country in props.countries" :key="country.id" :value="country.id">
                {{ country.name }}
              </option>
            </NativeSelect>
            <p v-if="form.errors.country_id" class="mt-1 text-sm text-destructive">
              {{ form.errors.country_id }}
            </p>
          </div>

          <!-- City -->
          <div>
            <Label for="city" class="mb-2 block">City/Town *</Label>
            <Input
              id="city"
              v-model="form.city"
              type="text"
              placeholder="e.g., New York"
            />
            <p v-if="form.errors.city" class="mt-1 text-sm text-destructive">
              {{ form.errors.city }}
            </p>
          </div>

          <!-- Address Line 1 -->
          <div>
            <Label for="address_line_1" class="mb-2 block">Address Line 1 *</Label>
            <Input
              id="address_line_1"
              v-model="form.address_line_1"
              type="text"
              placeholder="e.g., 123 Main Street"
            />
            <p v-if="form.errors.address_line_1" class="mt-1 text-sm text-destructive">
              {{ form.errors.address_line_1 }}
            </p>
          </div>

          <!-- Address Line 2 -->
          <div>
            <Label for="address_line_2" class="mb-2 block">Address Line 2</Label>
            <Input
              id="address_line_2"
              v-model="form.address_line_2"
              type="text"
              placeholder="e.g., Apt 4B (Optional)"
            />
          </div>
        </div>

        <!-- Step 4: Amenities -->
        <div v-show="currentStep === 3" class="space-y-6">
          <h3 class="text-lg font-semibold">Amenities & Summary</h3>
          <p class="text-sm text-muted-foreground">
            Select amenities and review your property details
          </p>

          <!-- Amenities -->
          <div v-if="props.amenities && props.amenities.length > 0">
            <Label class="mb-3 block font-semibold">Property Amenities</Label>
            <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
              <div
                v-for="amenity in props.amenities"
                :key="amenity.id"
                class="flex items-center gap-2"
              >
                <Checkbox
                  :id="`amenity-${amenity.id}`"
                  :checked="form.amenities.includes(amenity.id)"
                  @update:checked="toggleAmenity(amenity.id)"
                />
                <Label :for="`amenity-${amenity.id}`" class="font-normal cursor-pointer">
                  {{ amenity.name }}
                </Label>
              </div>
            </div>
          </div>

          <!-- Summary -->
          <div class="mt-8 space-y-4 rounded-lg bg-muted p-4">
            <h4 class="font-semibold">Property Summary</h4>
            <div class="grid grid-cols-2 gap-4 text-sm">
              <div>
                <p class="text-muted-foreground">Title</p>
                <p class="font-medium">{{ form.title }}</p>
              </div>
              <div>
                <p class="text-muted-foreground">Price</p>
                <p class="font-medium">${{ form.price.toLocaleString() }}</p>
              </div>
              <div>
                <p class="text-muted-foreground">Type</p>
                <p class="font-medium">
                  {{ propertyTypeOptions.find((t) => t.value === form.property_type)?.label }}
                </p>
              </div>
              <div>
                <p class="text-muted-foreground">Listing Type</p>
                <p class="font-medium">
                  {{ propertyListingTypeOptions.find((t) => t.value === form.listing_type)?.label }}
                </p>
              </div>
              <div>
                <p class="text-muted-foreground">Location</p>
                <p class="font-medium">{{ form.city }}</p>
              </div>
              <div>
                <p class="text-muted-foreground">Bedrooms</p>
                <p class="font-medium">{{ form.bedrooms }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Navigation Buttons -->
      <div class="flex items-center justify-between gap-4">
        <Button
          variant="outline"
          @click="prevStep"
          :disabled="currentStep === 0"
        >
          <ArrowLeft class="mr-2 h-4 w-4" /> Previous
        </Button>

        <div class="flex gap-2">
          <Button
            v-if="currentStep < STEPS.length - 1"
            @click="nextStep"
            :disabled="!canProceedToNextStep"
          >
            Next <ArrowRight class="ml-2 h-4 w-4" />
          </Button>
          <Button
            v-else
            @click="submitForm"
            :disabled="form.processing"
            class="bg-green-600 hover:bg-green-700"
          >
            <Check class="mr-2 h-4 w-4" />
            {{ form.processing ? 'Creating...' : 'Create Property' }}
          </Button>
        </div>
      </div>
    </div>
  </AgentLayout>
</template>