<script setup lang="ts">
import {  Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import {
    SidebarTrigger,
} from '@/components/ui/sidebar';
import UserMenuContent from '@/components/UserMenuContent.vue';
import { getInitials } from '@/composable/useInitials';
import { home, login, register } from '@/routes';
import { Button } from './ui/button';

const page = usePage();
const auth = computed(() => page.props.auth);

</script>

<template>
    <header
        class="flex h-16 shrink-0 items-center gap-2 transition-[width,height] ease-linear group-has-[[data-collapsible=icon]]/sidebar-wrapper:h-12">
        <div class="flex items-center gap-2 px-4">
            <SidebarTrigger class="-ml-1" />
            
            <div class="ml-auto flex items-center space-x-2">
                <div class="relative flex items-center space-x-1">
                    <Link :href="home()" >
                        <Button
                        variant="ghost"
                        size="icon"
                        class="px-8"> 
                            Home
                        </Button>
                    </Link>

                    <div class="ml-auto flex items-center space-x-2">
                        <DropdownMenu v-if="auth.user">
                            <DropdownMenuTrigger :as-child="true">
                                <Button
                                    variant="ghost"
                                    size="icon"
                                    class="relative size-10 w-auto rounded-full p-1 focus-within:ring-2 focus-within:ring-primary"
                                >
                                    <Avatar
                                        class="size-8 overflow-hidden rounded-full"
                                    >
                                        <AvatarImage
                                            v-if="auth.user.avatar"
                                            :src="auth.user.avatar"
                                            :alt="auth.user.name"
                                        />
                                        <AvatarFallback
                                            class="rounded-lg bg-neutral-200 font-semibold text-black dark:bg-neutral-700 dark:text-white"
                                        >
                                            {{ getInitials(auth.user?.name) }}
                                        </AvatarFallback>
                                    </Avatar>
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end" class="w-56">
                                <UserMenuContent :user="auth.user" />
                            </DropdownMenuContent>
                        </DropdownMenu>

                        <div v-else class="relative flex items-center space-x-1">
                            <Link :href="login()" >
                                <Button
                                variant="ghost"
                                size="icon"
                                class="px-8"> 
                                    Login
                                </Button>
                            </Link>
                            
                            <Link :href="register()" >
                                <Button
                                variant="ghost"
                                size="icon"
                                class="px-8"> 
                                    Register
                                </Button>
                            </Link>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>