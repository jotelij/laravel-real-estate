<script setup lang="ts">
import AgentLayout from '@/layouts/AgentLayout.vue';
import { User } from '@/types';
import BasicProfileInfo from './Sections/BasicProfileInfo.vue';
import DashboardHeader from '@/components/DashboardHeader.vue';

interface props {
    user: User;
    status?: string;
} 

const props = defineProps<props>();

</script>

<template>
    <AgentLayout>
        <div class="flex flex-1 flex-col gap-4 p-4 pt-0">
            <DashboardHeader title="Edit Information"
                description="You can update your profile information, change your password, or delete your account." />
            <BasicProfileInfo :user="props.user" :status="props.status" />
        </div>
    </AgentLayout>
</template>