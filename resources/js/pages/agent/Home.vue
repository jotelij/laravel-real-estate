<script setup lang="ts">
import HomeIndex from '@/components/common/HomeIndex.vue';
import GuestLayout from '@/layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';

</script>

<template>
    <Head title="Home" />
    <GuestLayout>
        <HomeIndex />
    </GuestLayout>
</template>