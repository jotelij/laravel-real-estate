<script setup lang="ts">
import AgentLayout from '@/layouts/AgentLayout.vue'
import { Property, Paginated } from '@/types'
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
import { ArrowUpDown, ChevronDown, Edit, Trash2, Eye, HousePlus } from 'lucide-vue-next'
import { h, ref } from 'vue'
import { get_property_image_path, timeAgo, valueUpdater } from '@/lib/utils'
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
import { Link, router } from '@inertiajs/vue3'
import properties from '@/routes/agent/properties'
import DashboardHeader from '@/components/DashboardHeader.vue'
import { getPropertyStatusValue, getPropertyTypeValue, getPropertyListingValue } from '@/lib/enum_utils'
import agent from '@/routes/agent'

interface Props {
  properties_data: Paginated<Property>
}

const props = defineProps<Props>()

const columns: ColumnDef<Property>[] = [
  {
    accessorKey: 'images',
    accessorFn: (row) => get_property_image_path(row.images),
    header: 'Image',
    cell: ({ row }) => {
      const imagePath = get_property_image_path(row.original.images)
      return h('img', { src: "https://cdn.shadcnstudio.com/ss-assets/blocks/marketing/gallery/image-10.png", alt: row.original.title, class: 'h-10 w-10 object-cover rounded' })
    },
    enableSorting: false,
    enableHiding: false,
  },
  {
    accessorKey: 'title',
    header: 'Title',
    cell: ({ row }) => {
      const title = row.getValue('title') as string
      const truncated = title.length > 40 ? title.slice(0, 40) + '...' : title
      return h('div', { class: 'font-medium max-w-xs truncate px-4' }, truncated)
    },
    enableSorting: false,
    enableHiding: false,
  },
  {
    accessorKey: 'property_type',
    header: ({ column }) => {
      return h(
        Button,
        {
          variant: 'ghost',
          size: 'sm',
          class: 'hover:bg-accent',
          onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
        },
        () => [h('span', 'Property Type'), h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })]
      )
    },
    cell: ({ row }) => {
      const propertyType = row.getValue('property_type') as any
      const typeValue = getPropertyTypeValue(propertyType)
      return h(
        'span',
        {
          class: `inline-block py-1 px-3 rounded-full text-xs font-semibold ${typeValue.badgeClass}`,
        },
        typeValue.label
      )
    },
    enableHiding: true,
  },
  {
    accessorKey: 'listing_type',
    header: 'Listing',
    cell: ({ row }) => {
      const listingType = row.getValue('listing_type') as any
      const typeValue = getPropertyListingValue(listingType)
      return h(
        'span',
        {
          class: `inline-block py-1 px-3 rounded-full text-xs font-semibold ${typeValue.badgeClass}`,
        },
        typeValue.label
      )
    },
    enableHiding: true,
  },
  {
    accessorKey: 'status',
    header: ({ column }) => {
      return h(
        Button,
        {
          variant: 'ghost',
          size: 'sm',
          class: 'hover:bg-accent',
          onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
        },
        () => [h('span', 'Status'), h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })]
      )
    },
    cell: ({ row }) => {
      const status = row.getValue('status') as any
      const statusValue = getPropertyStatusValue(status)
      return h(
        'div',
        {
          class: `inline-block py-1 px-3 rounded-full text-xs font-semibold ${statusValue.badgeClass}`,
        },
        statusValue.label
      )
    },
  },
  {
    accessorKey: 'price',
    header: ({ column }) => {
      return h(
        Button,
        {
          variant: 'ghost',
          size: 'sm',
          class: 'hover:bg-accent',
          onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
        },
        () => [h('span', 'Price'), h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })]
      )
    },
    cell: ({ row }) => {
      const price = row.getValue('price') as number
      return h('div', { class: 'font-medium' }, `$${price.toLocaleString()}`)
    },
  },
  {
    accessorKey: 'bedrooms',
    header: 'Beds',
    cell: ({ row }) => {
      const bedrooms = row.getValue('bedrooms') as number
      return h('div', { class: 'text-center' }, bedrooms.toString())
    },
    enableHiding: true,
  },
  {
    accessorKey: 'bathrooms',
    header: 'Baths',
    cell: ({ row }) => {
      const bathrooms = row.getValue('bathrooms') as number
      return h('div', { class: 'text-center' }, bathrooms.toString())
    },
    enableHiding: true,
  },
  {
    accessorKey: 'created_at',
    header: ({ column }) => {
      return h(
        Button,
        {
          variant: 'ghost',
          size: 'sm',
          class: 'hover:bg-accent',
          onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
        },
        () => [h('span', 'Created'), h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })]
      )
    },
    cell: ({ row }) => h('div', { class: 'text-sm text-muted-foreground' }, timeAgo(row.getValue('created_at'))),
  },
  {
    accessorKey: 'views_count',
    header: 'Views',
    cell: ({ row }) => {
      const views = row.getValue('views_count') as number
      return h('div', { class: 'text-center text-sm' }, views.toString())
    },
    enableHiding: true,
  },
  {
    id: 'actions',
    header: 'Actions',
    enableHiding: false,
    cell: ({ row }) => {
      const property = row.original
      return h('div', { class: 'flex gap-2' }, [
        h(
          Link,
          {
            href: properties.edit(property.id),
            class:
              'inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors hover:bg-accent hover:text-accent-foreground h-9 px-3',
          },
          () => [h(Edit, { class: 'h-4 w-4 mr-1' }), 'Edit']
        ),
        h(
          'button',
          {
            type: 'button',
            class:
              'inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors hover:bg-destructive hover:text-destructive-foreground h-9 px-3',
            onClick: () => {
              if (confirm(`Are you sure you want to delete "${property.title}"?`)) {
                router.delete(`/agent/properties/${property.id}`)
              }
            },
          },
          () => [h(Trash2, { class: 'h-4 w-4 mr-1' }), 'Delete']
        ),
      ])
    },
  },
]

const sorting = ref<SortingState>([{ id: 'created_at', desc: true }])
const columnFilters = ref<ColumnFiltersState>([])
const columnVisibility = ref<VisibilityState>({})

const table = useVueTable({
  data: props.properties_data.data,
  columns,
  getCoreRowModel: getCoreRowModel(),
  getPaginationRowModel: getPaginationRowModel(),
  getSortedRowModel: getSortedRowModel(),
  getFilteredRowModel: getFilteredRowModel(),
  onSortingChange: (updaterOrValue) => valueUpdater(updaterOrValue, sorting),
  onColumnFiltersChange: (updaterOrValue) => valueUpdater(updaterOrValue, columnFilters),
  onColumnVisibilityChange: (updaterOrValue) => valueUpdater(updaterOrValue, columnVisibility),
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
  <AgentLayout>
    <div class="flex flex-1 flex-col gap-4 p-4 pt-0">
      <div class="flex items-center justify-between">
        <DashboardHeader
          title="Properties"
          description="Manage your property listings" />
        <Link
          :href="agent.properties.create()"
          class="inline-flex items-center justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground transition-colors hover:bg-primary/90"
        >
          <HousePlus class="mr-2" /> New Property
        </Link>
      </div>

      <div class="w-full bg-background rounded-lg border">
        <div class="flex items-center gap-2 p-4 border-b">
          <Input
            class="max-w-sm"
            placeholder="Filter by title..."
            :model-value="(table.getColumn('title')?.getFilterValue() as string) ?? ''"
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
                @update:checked="(value: any) => column.toggleVisibility(!!value)"
              >
                {{ column.id }}
              </DropdownMenuCheckboxItem>
            </DropdownMenuContent>
          </DropdownMenu>
        </div>

        <div class="overflow-x-auto">
          <Table>
            <TableHeader>
              <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                <TableHead v-for="header in headerGroup.headers" :key="header.id" class="whitespace-nowrap">
                  <FlexRender
                    v-if="!header.isPlaceholder"
                    :render="header.column.columnDef.header"
                    :props="header.getContext()"
                  />
                </TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              <template v-if="table.getRowModel().rows?.length">
                <TableRow v-for="row in table.getRowModel().rows" :key="row.id" class="hover:bg-muted/50">
                  <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                    <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                  </TableCell>
                </TableRow>
              </template>
              <TableRow v-else>
                <TableCell :colspan="columns.length" class="h-24 text-center">
                  <div class="flex flex-col items-center justify-center gap-2">
                    <Eye class="h-8 w-8 text-muted-foreground opacity-50" />
                    <p class="text-muted-foreground">No properties yet</p>
                    <Link
                      :href="agent.properties.create()"
                      class="text-sm text-primary hover:underline"
                    >
                      Create your first property listing
                    </Link>
                  </div>
                </TableCell>
              </TableRow>
            </TableBody>
          </Table>
        </div>

        <div class="flex items-center justify-between px-4 py-4 border-t text-sm text-muted-foreground">
          <div>
            Page {{ table.getState().pagination.pageIndex + 1 }} of {{ table.getPageCount() }} ({{
              table.getFilteredRowModel().rows.length
            }}
            total)
          </div>
          <div class="flex gap-2">
            <Button
              variant="outline"
              size="sm"
              @click="() => table.previousPage()"
              :disabled="!table.getCanPreviousPage()"
            >
              Previous
            </Button>
            <Button
              variant="outline"
              size="sm"
              @click="() => table.nextPage()"
              :disabled="!table.getCanNextPage()"
            >
              Next
            </Button>
          </div>
        </div>
      </div>
    </div>
  </AgentLayout>
</template>