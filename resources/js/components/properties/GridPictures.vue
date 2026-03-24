<script setup lang="ts">

// const props = defineProps<{
//     images: string[]
// }>();
const imgggg = "https://cdn.shadcnstudio.com/ss-assets/blocks/marketing/gallery/image-10.png";

</script>

<template>
    <div class='grid gap-1 lg:grid-cols-2'>
        <img :src="imgggg" alt="Property Image" class='rounded-sm object-cover' />
        <img :src="imgggg" alt="Property Image" class='rounded-sm object-cover' />
        <img :src="imgggg" alt="Property Image" class='rounded-sm object-cover' />
        <img :src="imgggg" alt="Property Image" class='rounded-sm object-cover' />
    </div>
</template>