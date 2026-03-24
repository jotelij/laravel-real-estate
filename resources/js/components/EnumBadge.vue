<script lang="ts" setup>
import { EnumOption } from '@/types';
import Badge from './ui/badge/Badge.vue';

interface Props<T> {
    enumOption: EnumOption<T>;
}

const props =defineProps<Props<any>>();

</script>

<template>
    <span>
        <Badge variant="secondary" class='text-sm font-semibold px-3 py-1' :class="props.enumOption.badgeClass">
            {{ props.enumOption.label }}
        </Badge>
    </span>
</template>