<script lang="ts" setup>

withDefaults(defineProps<{
    title: string;
    description?: string;
}>(), {
    title: 'Dashboard',
});

</script>

<template>
    <div class="flex flex-col items-start justify-between gap-4 md:flex-row md:items-center">
        <div>
            <h1 class="text-3xl font-bold tracking-tight">{{ title }}</h1>
            <p class="text-muted-foreground mt-1">{{ description }}</p>
        </div>
    </div>
</template>