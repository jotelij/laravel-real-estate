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
import { ArrowUpDown, ChevronDown, MessageSquare, User } from 'lucide-vue-next'
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
import { getEnquiryStatusValue } from '@/lib/enum_utils'
import { timeAgo, valueUpdater } from '@/lib/utils'
import enquiries from '@/routes/customer/enquiries';
import type { Enquiry, EnquiryStatusRaw, Paginated } from '@/types';

interface Props {
  enquiries_data: Paginated<Enquiry>
}

const props = defineProps<Props>();

const columns: ColumnDef<Enquiry>[] = [
  {
    accessorKey: 'title',
    accessorFn: (row) => row.property?.title ?? 'N/A',
    header: 'Property',
    cell: ({ row }) => {
      const hasUnread = row.original.messages?.some(msg => msg.sender_id !== row.original.sender_id && msg.read_at === null);
      const title = row.original.property?.title ?? 'N/A'
      const truncated = title.length > 40 ? title.slice(0, 40) + '...' : title

      return h('div', { class: `font-medium max-w-xs truncate px-4 ${hasUnread ? 'font-semibold' : ''}` }, truncated)
    },
    enableSorting: false,
    enableHiding: false,
  },
  {
    accessorKey: 'subject',
    header: 'Subject',
    cell: ({ row }) => {
      const hasUnread = row.original.messages?.some(msg => msg.sender_id !== row.original.sender_id && msg.read_at === null);
      const subject = row.getValue('subject') as string
      const truncated = subject.length > 40 ? subject.slice(0, 40) + '...' : subject

      return h('div', { class: `text-sm ${hasUnread ? 'font-semibold' : ''}` }, truncated)
    },
    enableSorting: false,
  },
  {
    accessorKey: 'agency_name',
    accessorFn: (row) => row.agent?.agent_profile?.agency_name ?? 'N/A',
    header: 'Agent',
    cell: ({ row }) => {
      const hasUnread = row.original.messages?.some(msg => msg.sender_id !== row.original.sender_id && msg.read_at === null);
      const agencyName = row.original.agent?.agent_profile?.agency_name ?? ''
      const truncated = agencyName.length > 40 ? agencyName.slice(0, 40) + '...' : agencyName

      return h('div', { class: `flex items-center gap-2 text-sm ${hasUnread ? 'font-semibold' : ''}` }, [
        h(User, { class: 'h-4 w-4 text-muted-foreground' }),
        h('span', truncated)
      ])
    },
    enableSorting: false,
  },
  {
    accessorKey: 'created_at',
    header: ({ column }) => {
      return h(Button, {
        variant: 'ghost',
        size: 'sm',
        class: 'hover:bg-accent',
        onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
      }, () => [
        h('span', 'Created'),
        h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })
      ])
    },
    cell: ({ row }) => {
      const hasUnread = row.original.messages?.some(msg => msg.sender_id !== row.original.sender_id && msg.read_at === null);

      return h('div', { class: `text-sm text-muted-foreground ${hasUnread ? 'font-semibold' : ''}` }, timeAgo(row.getValue('created_at')));
    },
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
      const status = row.getValue('status') as EnquiryStatusRaw
      const statusValue = getEnquiryStatusValue(status)

      return h('div', { class: `inline-block py-1 px-3 rounded-full text-xs font-semibold ${statusValue.badgeClass}` }, statusValue.label)
    },
  },
  {
    accessorKey: 'messages_count',
    header: 'Messages',
    cell: ({ row }) => {
      const hasUnread = row.original.messages?.some(msg => msg.sender_id !== row.original.sender_id && msg.read_at === null);
      const count = row.original.messages?.length ?? 0;

      return h('div', { class: `flex items-center gap-1 text-sm ${hasUnread ? 'font-bold' : ''}` }, [
        h(MessageSquare, { class: 'h-4 w-4' }),
        h('span', count.toString())
      ])
    },
    enableSorting: false,
  },
  {
    id: 'actions',
    header: 'Actions',
    enableHiding: false,
    cell: ({ row }) => {
      const enquiry = row.original;

      return h(Link, {
        href: enquiries.show(enquiry.id),   
        class: 'inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors hover:bg-accent hover:text-accent-foreground h-9 px-3',
      }, () => 'View')
    },
  },
]

const sorting = ref<SortingState>([{ id: 'created_at', desc: true }])
const columnFilters = ref<ColumnFiltersState>([])
const columnVisibility = ref<VisibilityState>({})

const table = useVueTable({
  data: props.enquiries_data.data,
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
    <Head title="Enquiries" />

  <CustomerLayout>
    <div class="flex flex-1 flex-col gap-4 p-4 pt-0">
      <DashboardHeader
        title="My Enquiries"
        description="Manage your property enquiries and messages" />  

      <div class="w-full bg-background rounded-lg border">
        <div class="flex items-center gap-2 p-4 border-b">
          <Input
            class="max-w-sm"
            placeholder="Filter by subject..."
            :model-value="table.getColumn('subject')?.getFilterValue() as string"
            @update:model-value="table.getColumn('subject')?.setFilterValue($event)"
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

        <div class="overflow-x-auto">
          <Table>
            <TableHeader>
              <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                <TableHead v-for="header in headerGroup.headers" :key="header.id" class="whitespace-nowrap">
                  <FlexRender v-if="!header.isPlaceholder" :render="header.column.columnDef.header" :props="header.getContext()" />
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
                    <MessageSquare class="h-8 w-8 text-muted-foreground opacity-50" />
                    <p class="text-muted-foreground">No enquiries yet</p>
                  </div>
                </TableCell>
              </TableRow>
            </TableBody>
          </Table>
        </div>

        <div class="flex items-center justify-between px-4 py-4 border-t text-sm text-muted-foreground">
          <div>
            Page {{ table.getState().pagination.pageIndex + 1 }} of {{ table.getPageCount() }} ({{ table.getFilteredRowModel().rows.length }} total)
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
  </CustomerLayout>
</template>