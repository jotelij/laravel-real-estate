<script setup lang="ts">
import { Enquiry, Paginated } from '@/types';
import DashboardHeader from '@/components/DashboardHeader.vue';
import AgentLayout from '@/layouts/AgentLayout.vue';
import EnquiryTable from '@/components/enquiry/EnquiryTable.vue';

interface Props {
  enquiries: Paginated<Enquiry>
}

const props = defineProps<Props>();

</script>

<template>
  <AgentLayout>
    <div class="flex flex-1 flex-col gap-4 p-4 pt-0">
      <DashboardHeader
        title="Enquiries Received"
        description="Manage your property enquiries and messages" />  

      <EnquiryTable :enquiries="props.enquiries.data" />
    </div>
  </AgentLayout>
</template>