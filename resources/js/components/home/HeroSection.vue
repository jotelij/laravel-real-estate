<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Search } from 'lucide-vue-next';
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import guest from '@/routes/guest';

const searchQuery = ref('');

function handleSearch() {
    window.location.href = `${guest.properties.index()}?search=${searchQuery.value}`;
}
</script>

<template>
    <div class="relative w-full py-20 px-4 bg-gradient-to-br from-blue-600 via-blue-500 to-blue-700 text-white overflow-hidden">
        <!-- Background decorative elements -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        
        <div class="relative mx-auto max-w-6xl">
            <div class="text-center mb-12">
                <h1 class="text-5xl md:text-6xl font-bold mb-4 leading-tight">
                    Find Your Dream Home
                </h1>
                <p class="text-xl md:text-2xl text-blue-100 mb-8 max-w-3xl mx-auto">
                    Discover exceptional properties managed by trusted real estate professionals
                </p>
            </div>

            <!-- Search Bar -->
            <div class="flex flex-col md:flex-row gap-3 max-w-2xl mx-auto mb-8">
                <div class="flex-1 flex items-center bg-white rounded-lg px-4 py-3">
                    <Search class="w-5 h-5 text-gray-400 mr-2" />
                    <input
                        v-model="searchQuery"
                        type="text"
                        placeholder="Search properties by location, type..."
                        class="flex-1 outline-none text-gray-700 bg-transparent"
                        @keyup.enter="handleSearch"
                    />
                </div>
                <Button
                    @click="handleSearch"
                    class="bg-blue-700 hover:bg-blue-800 text-white px-8 py-3 rounded-lg font-semibold h-auto"
                >
                    Search
                </Button>
            </div>

            <!-- Quick Links -->
            <div class="flex flex-wrap justify-center gap-4 text-blue-100 text-sm">
                <Link :href="guest.properties.index()" class="hover:text-white transition">
                    Browse All Properties
                </Link>
                <span>·</span>
                <a href="#featured" class="hover:text-white transition">
                    Featured Listings
                </a>
                <span>·</span>
                <a href="#how-it-works" class="hover:text-white transition">
                    How It Works
                </a>
            </div>
        </div>
    </div>
</template>

<style scoped>
@keyframes blob {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}
</style>
