<script setup lang="ts">
import DashboardHeader from '@/components/DashboardHeader.vue';
import AgentLayout from '@/layouts/AgentLayout.vue';
import type { User } from '@/types';
import BasicProfileInfo from '../profile/Sections/BasicProfileInfo.vue';

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