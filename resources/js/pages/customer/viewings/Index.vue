<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import type {
  ColumnDef,
  ColumnFiltersState,
  SortingState,
  VisibilityState,
} from '@tanstack/vue-table'
import {
  FlexRender,
  getCoreRowModel,
  getFilteredRowModel,
  getPaginationRowModel,
  getSortedRowModel,
  useVueTable,
} from '@tanstack/vue-table'
import { ArrowUpDown, ChevronDown, Calendar, MapPin, User, Eye } from 'lucide-vue-next'
import { h, ref } from 'vue'
import DashboardHeader from '@/components/DashboardHeader.vue';
import { Button } from '@/components/ui/button'
import {
  DropdownMenu,
  DropdownMenuCheckboxItem,
  DropdownMenuContent,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import { Input } from '@/components/ui/input'
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'
import CustomerLayout from '@/layouts/CustomerLayout.vue';
import { getViewingsStatusValue } from '@/lib/enum_utils'
import { timeAgo, valueUpdater, formatDate } from '@/lib/utils'
import type { Viewing, Paginated } from '@/types';

interface Props {
  viewings: Paginated<Viewing>
}

const props = defineProps<Props>();


const columns: ColumnDef<Viewing>[] = [
  {
    accessorKey: 'title',
    accessorFn: (row) => row.property?.title ?? 'N/A',
    header: 'Property',
    cell: ({ row }) => {
      const title = row.original.property?.title ?? 'N/A'
      const truncated = title.length > 35 ? title.slice(0, 35) + '...' : title

      return h('div', { class: 'font-medium max-w-xs truncate px-4' }, truncated)
    },
    enableSorting: false,
    enableHiding: false,
  },
  {
    accessorKey: 'scheduled_at',
    header: ({ column }) => {
      return h(Button, {
        variant: 'ghost',
        size: 'sm',
        class: 'hover:bg-accent',
        onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
      }, () => [
        h('span', 'Scheduled Date'),
        h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })
      ])
    },
    cell: ({ row }) => {
      const scheduledAt = row.getValue('scheduled_at') as string

      return h('div', { class: 'flex items-center gap-2 text-sm' }, [
        h(Calendar, { class: 'h-4 w-4 text-muted-foreground' }),
        h('span', formatDate(scheduledAt))
      ])
    },
  },
  {
    accessorKey: 'agency_name',
    accessorFn: (row) => row.agent?.agent_profile?.agency_name ?? 'N/A',
    header: 'Agent',
    cell: ({ row }) => {
      const agentName = row.original.agent?.name ?? 'N/A'
      const agencyName = row.original.agent?.agent_profile?.agency_name ?? ''
      const display = agencyName ? `${agentName} (${agencyName})` : agentName
      const truncated = display.length > 40 ? display.slice(0, 40) + '...' : display

      return h('div', { class: 'flex items-center gap-2 text-sm' }, [
        h(User, { class: 'h-4 w-4 text-muted-foreground' }),
        h('span', truncated)
      ])
    },
    enableSorting: false,
  },
  {
    accessorKey: 'status',
    header: ({ column }) => {
      return h(Button, {
        variant: 'ghost',
        size: 'sm',
        class: 'hover:bg-accent',
        onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
      }, () => [
        h('span', 'Status'),
        h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })
      ])
    },
    cell: ({ row }) => {
      const status = row.getValue('status') as number
      const statusValue = getViewingsStatusValue(status)

      return h('div', { class: `inline-block py-1 px-3 rounded-full text-xs font-semibold ${statusValue.badgeClass}` }, statusValue.label)
    },
  },
  {
    accessorKey: 'notes',
    header: 'Notes',
    cell: ({ row }) => {
      const notes = row.getValue('notes') as string
      const display = notes && notes.length > 0 ? (notes.length > 30 ? notes.slice(0, 30) + '...' : notes) : 'N/A'

      return h('div', { class: 'text-sm text-muted-foreground' }, display)
    },
    enableSorting: false,
  },
  {
    accessorKey: 'created_at',
    header: 'Requested',
    cell: ({ row }) => h('div', { class: 'text-sm text-muted-foreground' }, timeAgo(row.getValue('created_at'))),
    enableSorting: false,
  },
  {
    id: 'actions',
    header: 'Actions',
    enableHiding: false,
    cell: ({ row }) => {
      const viewing = row.original

      return h('div', { class: 'flex items-center gap-2' }, [
        h(Link, {
          href: `/customer/viewings/${viewing.id}`,
          class: 'inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors hover:bg-accent hover:text-accent-foreground h-9 px-3',
        }, () => [
          h(Eye, { class: 'h-4 w-4' })
        ]),
      ])
    },
  },
]

const sorting = ref<SortingState>([{ id: 'scheduled_at', desc: true }])
const columnFilters = ref<ColumnFiltersState>([])
const columnVisibility = ref<VisibilityState>({})

const table = useVueTable({
  data: props.viewings.data,
  columns,
  getCoreRowModel: getCoreRowModel(),
  getPaginationRowModel: getPaginationRowModel(),
  getSortedRowModel: getSortedRowModel(),
  getFilteredRowModel: getFilteredRowModel(),
  onSortingChange: updaterOrValue => valueUpdater(updaterOrValue, sorting),
  onColumnFiltersChange: updaterOrValue => valueUpdater(updaterOrValue, columnFilters),
  onColumnVisibilityChange: updaterOrValue => valueUpdater(updaterOrValue, columnVisibility),
  state: {
    get sorting() {
 return sorting.value 
},
    get columnFilters() {
 return columnFilters.value 
},
    get columnVisibility() {
 return columnVisibility.value 
},
  },
})
</script>

<template>
    <Head title="Dashboard" />

  <CustomerLayout>
    <div class="flex flex-1 flex-col gap-4 p-4 pt-0">
      <DashboardHeader
        title="My Viewings"
        description="Manage your property viewings and appointments" />

      <div class="w-full bg-background rounded-lg border shadow-sm">
        <!-- Header with filters -->
        <div class="flex items-center gap-2 p-4 border-b bg-muted/30">
          <Input
            class="max-w-sm"
            placeholder="Filter by property..."
            :model-value="table.getColumn('title')?.getFilterValue() as string"
            @update:model-value="table.getColumn('title')?.setFilterValue($event)"
          />
          <DropdownMenu>
            <DropdownMenuTrigger as-child>
              <Button variant="outline" size="sm" class="ml-auto">
                Columns
                <ChevronDown class="ml-2 h-4 w-4" />
              </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end">
              <DropdownMenuCheckboxItem
                v-for="column in table.getAllColumns().filter((column) => column.getCanHide())"
                :key="column.id"
                class="capitalize"
                :checked="column.getIsVisible()"
                @update:checked="(value: boolean | undefined) => column.toggleVisibility(!!value)"
              >
                {{ column.id }}
              </DropdownMenuCheckboxItem>
            </DropdownMenuContent>
          </DropdownMenu>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
          <Table>
            <TableHeader>
              <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id" class="border-b-2">
                <TableHead v-for="header in headerGroup.headers" :key="header.id" class="whitespace-nowrap font-semibold">
                  <FlexRender v-if="!header.isPlaceholder" :render="header.column.columnDef.header" :props="header.getContext()" />
                </TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              <template v-if="table.getRowModel().rows?.length">
                <TableRow v-for="row in table.getRowModel().rows" :key="row.id" class="hover:bg-muted/50 transition-colors">
                  <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id" class="py-4">
                    <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                  </TableCell>
                </TableRow>
              </template>
              <TableRow v-else>
                <TableCell :colspan="columns.length" class="h-32 text-center">
                  <div class="flex flex-col items-center justify-center gap-3">
                    <MapPin class="h-10 w-10 text-muted-foreground opacity-40" />
                    <div>
                      <p class="text-muted-foreground font-medium">No viewings yet</p>
                      <p class="text-sm text-muted-foreground mt-1">Schedule a viewing to get started</p>
                    </div>
                  </div>
                </TableCell>
              </TableRow>
            </TableBody>
          </Table>
        </div>

        <!-- Footer with pagination -->
        <div class="flex items-center justify-between px-4 py-4 border-t bg-muted/30">
          <div class="text-sm text-muted-foreground">
            Page <span class="font-semibold">{{ table.getState().pagination.pageIndex + 1 }}</span> of <span class="font-semibold">{{ table.getPageCount() }}</span> 
            (<span class="font-semibold">{{ table.getFilteredRowModel().rows.length }}</span> total)
          </div>
          <div class="flex gap-2">
            <Button
              variant="outline"
              size="sm"
              @click="() => table.previousPage()"
              :disabled="!table.getCanPreviousPage()"
              class="gap-2"
            >
              Previous
            </Button>
            <Button
              variant="outline"
              size="sm"
              @click="() => table.nextPage()"
              :disabled="!table.getCanNextPage()"
              class="gap-2"
            >
              Next
            </Button>
          </div>
        </div>
      </div>
    </div>
  </CustomerLayout>
</template>