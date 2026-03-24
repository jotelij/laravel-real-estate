<script setup lang="ts">
import DashboardHeader from '@/components/DashboardHeader.vue';
import EnquiryTable from '@/components/enquiry/EnquiryTable.vue';
import AgentLayout from '@/layouts/AgentLayout.vue';
import type { Enquiry, Paginated } from '@/types';

interface Props {
  enquiries_data: Paginated<Enquiry>
}

const props = defineProps<Props>();

</script>

<template>
  <AgentLayout>
    <div class="flex flex-1 flex-col gap-4 p-4 pt-0">
      <DashboardHeader
        title="Enquiries Received"
        description="Manage your property enquiries and messages" />  

      <EnquiryTable :enquiries_data="props.enquiries_data.data" />
    </div>
  </AgentLayout>
</template>