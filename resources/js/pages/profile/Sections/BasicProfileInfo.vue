<script setup lang="ts">
import { User } from '@/types';
import UpdateInfo from './UpdateInfo.vue';
import UpdatePassword from './UpdatePassword.vue';
import DeleteAccount from './DeleteAccount.vue';

interface props {
    user: User;
    status?: string;
} 

const props = defineProps<props>();

</script>
<template>
    <div
        v-if="props.status"
        class="mb-4 text-center text-sm font-medium text-green-600"
        >
        {{ props.status }}
    </div>

    <div class="mt-6 grid gap-6 md:grid-cols-2">
        <UpdateInfo :user="props.user" :status="props.status" />
        <UpdatePassword />
        <DeleteAccount />
    </div>
</template>