<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { register } from '@/routes';
import guest from '@/routes/guest';
</script>

<template>
    <section class="py-16 px-4 bg-gradient-to-br from-blue-600 to-blue-700 text-white">
        <div class="mx-auto max-w-4xl text-center">
            <h2 class="text-4xl font-bold mb-4">
                Ready to Find Your Dream Home?
            </h2>
            <p class="text-xl text-blue-100 mb-8">
                Join thousands of satisfied customers who found their perfect property with us
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <Link :href="guest.properties.index()">
                    <Button class="bg-white hover:bg-gray-100 text-blue-600 px-8 py-3 h-auto text-lg font-semibold">
                        Browse Properties
                    </Button>
                </Link>
                <Link :href="register()">
                    <Button class="bg-blue-500 hover:bg-blue-400 text-white px-8 py-3 h-auto text-lg font-semibold border-2 border-white">
                        Create Account
                    </Button>
                </Link>
            </div>

            <!-- Trust Badges -->
            <div class="mt-12 pt-8 border-t border-blue-400 flex flex-col sm:flex-row justify-center items-center gap-8 text-sm text-blue-100">
                <div>✓ Verified Properties</div>
                <div>✓ Licensed Agents</div>
                <div>✓ Secure Transactions</div>
            </div>
        </div>
    </section>
</template>
