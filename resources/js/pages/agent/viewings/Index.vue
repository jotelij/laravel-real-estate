<script setup lang="ts">
import { fromDate, getLocalTimeZone } from '@internationalized/date'
import type { DateValue } from '@internationalized/date';
import { Calendar } from 'lucide-vue-next'
import type { Ref} from 'vue';
import { ref, computed, onMounted, watch } from 'vue'
import DashboardHeader from '@/components/DashboardHeader.vue'
import { Calendar as CalendarComponent } from '@/components/ui/calendar'
import AppointmentCard from '@/components/viewings/AppointmentCard.vue'
import AgentLayout from '@/layouts/AgentLayout.vue'
import { formatDateShort } from '@/lib/utils'
import type { Viewing } from '@/types'


interface Props {
  groupedViewings: Record<string, Viewing[]>
  viewingDates: string[]
}

const props = defineProps<Props>()

const selectedDate = ref(fromDate(new Date(), getLocalTimeZone())) as Ref<DateValue>
const calendarElement = ref<HTMLElement | null>(null)

// Get viewings for selected date
const selectedDateViewings = computed(() => {
  const dateKey = selectedDate.value.toString().split('T')[0]

  return props.groupedViewings[dateKey] || []
})

// Check if date has viewings
// const hasViewings = (date: Date) => {
//   const dateKey = date.toISOString().split('T')[0]

//   return props.viewingDates.includes(dateKey)
// }

// Mark calendar dates with viewings
const markCalendarDates = () => {
  if (!calendarElement.value) {
return
}

  const cells = calendarElement.value.querySelectorAll('[data-slot="calendar-cell-trigger"]')
  
  cells.forEach((cell: Element) => {
    // Get the date from the cell's content or aria-label
    // const ariaLabel = (cell as HTMLElement).getAttribute('aria-label')
    const cellText = (cell as HTMLElement).textContent?.trim()
    
    if (cellText && !isNaN(Number(cellText))) {
      const dayNum = parseInt(cellText)
      
      // Try to determine the month/year from the calendar context
      // const monthYear = calendarElement.value?.querySelector('[data-slot="calendar-heading"]')?.textContent || ''
      
      // Find all viewing dates for this day
      const viewingsForDay = props.viewingDates.filter(dateStr => {
        const date = new Date(dateStr)

        return date.getDate() === dayNum
      })

      if (viewingsForDay.length > 0) {
        // Add indicator dot
        (cell as HTMLElement).style.position = 'relative'
        
        const existingDot = (cell as HTMLElement).querySelector('.viewing-indicator')

        if (!existingDot) {
          const dot = document.createElement('span')
          dot.className = 'viewing-indicator'
          dot.style.cssText = `
            position: absolute;
            bottom: 2px;
            left: 50%;
            transform: translateX(-50%);
            width: 6px;
            height: 6px;
            background-color: #3b82f6;
            border-radius: 50%;
            display: block;
          `
          dot.title = `${viewingsForDay.length} viewing(s)`
          ;(cell as HTMLElement).appendChild(dot)
        }
      }
    }
  })
}

// Watch for calendar updates and viewing dates changes
watch([selectedDate, () => props.viewingDates], () => {
  setTimeout(() => {
    markCalendarDates()
  }, 100)
}, { deep: true })

// Initial marking when component mounts
onMounted(() => {
  setTimeout(() => {
    markCalendarDates()
  }, 100)
})
</script>

<template>
    <AgentLayout>
        <div class="flex flex-1 flex-col gap-4 p-4 pt-0">
        <DashboardHeader 
            title="Viewings Schedule"
            description="Manage and view all your scheduled property viewings." />
        
        <div class="grid gap-4 lg:grid-cols-4">
            <!-- Calendar Section -->
            <div class="lg:col-span-1">
            <div class="rounded-lg border bg-white p-4">
                <div ref="calendarElement" class="w-full">
                    <CalendarComponent 
                    v-model="selectedDate"
                    class="w-full"
                    />
                </div>
                
                <!-- Legend -->
                <div class="mt-6 space-y-2 border-t pt-4">
                <p class="text-xs font-semibold text-gray-600 uppercase">Status Legend</p>
                <div class="space-y-2 text-xs">
                    <div class="flex items-center gap-2">
                    <div class="h-2 w-2 rounded-full bg-blue-500"></div>
                    <span>Requested</span>
                    </div>
                    <div class="flex items-center gap-2">
                    <div class="h-2 w-2 rounded-full bg-green-500"></div>
                    <span>Confirmed</span>
                    </div>
                    <div class="flex items-center gap-2">
                    <div class="h-2 w-2 rounded-full bg-gray-500"></div>
                    <span>Completed</span>
                    </div>
                    <div class="flex items-center gap-2">
                    <div class="h-2 w-2 rounded-full bg-red-500"></div>
                    <span>Cancelled</span>
                    </div>
                </div>
                </div>
                
                <!-- Calendar Indicators -->
                <div class="mt-4 space-y-1 border-t pt-4">
                <p class="text-xs font-semibold text-gray-600 uppercase">Calendar</p>
                <div class="flex items-center gap-2 text-xs">
                    <div class="h-1.5 w-1.5 rounded-full bg-blue-500"></div>
                    <span>Date has viewings</span>
                </div>
                </div>
            </div>
            </div>

            <!-- Viewings List Section -->
            <div class="lg:col-span-3">
            <div class="rounded-lg border bg-white p-4">
                <div class="mb-6 flex items-center justify-between border-b pb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">
                    {{ formatDateShort(selectedDate.toString().split('T')[0]) }}
                    </h3>
                    <p class="mt-1 text-sm text-gray-600">
                    {{ selectedDateViewings.length }} viewing{{ selectedDateViewings.length !== 1 ? 's' : '' }} scheduled
                    </p>
                </div>
                </div>

                <!-- No Viewings Message -->
                <div v-if="selectedDateViewings.length === 0" class="flex flex-col items-center justify-center py-12">
                <Calendar class="mb-4 h-12 w-12 text-gray-400" />
                <h4 class="mb-2 text-lg font-medium text-gray-600">No viewings scheduled</h4>
                <p class="text-sm text-gray-500">Select a date with viewings to see details</p>
                </div>

                <!-- Viewings List -->
                <div v-else class="space-y-3">
                     <div 
                          v-for="viewing in selectedDateViewings" 
                          :key="viewing.id"
                          class="flex items-start gap-4 rounded-lg border border-gray-200 p-4 hover:border-gray-300 hover:shadow-sm transition-all"
                      >
                      <AppointmentCard :viewing="viewing" :is_for_agent="true" />
                      </div>
                
                </div>
            </div>
            </div>
        </div>

        <!-- Upcoming Viewings Quick Summary -->
        <div class="rounded-lg border bg-white p-4">
            <h3 class="mb-4 font-semibold text-gray-900">Quick Summary</h3>
            <div class="grid gap-4 sm:grid-cols-4">
            <div class="rounded-lg bg-blue-50 p-4">
                <p class="text-xs text-blue-600">Total Scheduled</p>
                <p class="mt-1 text-2xl font-bold text-blue-900">
                {{ Object.values(groupedViewings).flat().length }}
                </p>
            </div>
            <div class="rounded-lg bg-green-50 p-4">
                <p class="text-xs text-green-600">Confirmed</p>
                <p class="mt-1 text-2xl font-bold text-green-900">
                {{ Object.values(groupedViewings).flat().filter(v => v.status === 2).length }}
                </p>
            </div>
            <div class="rounded-lg bg-orange-50 p-4">
                <p class="text-xs text-orange-600">Pending</p>
                <p class="mt-1 text-2xl font-bold text-orange-900">
                {{ Object.values(groupedViewings).flat().filter(v => v.status === 1).length }}
                </p>
            </div>
            <div class="rounded-lg bg-red-50 p-4">
                <p class="text-xs text-red-600">Cancelled</p>
                <p class="mt-1 text-2xl font-bold text-red-900">
                {{ Object.values(groupedViewings).flat().filter(v => v.status === 4).length }}
                </p>
            </div>
            </div>
        </div>
        </div>
    </AgentLayout>
</template>