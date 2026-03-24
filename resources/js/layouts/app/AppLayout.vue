<script setup lang="ts">
import type { BreadcrumbItem, NavItem } from '@/types';
import { Home, User2 } from 'lucide-vue-next'
import {
  NavigationMenu,
  NavigationMenuItem,
  NavigationMenuList,
  navigationMenuTriggerStyle,
} from '@/components/ui/navigation-menu';
import { dashboard, home, login, register } from '@/routes';
import { Link, usePage } from '@inertiajs/vue3';
import AppLogo from '@/components/AppLogo.vue';
import { useCurrentUrl } from '@/composable/useCurrentUrl';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Button } from '@/components/ui/button';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { computed } from 'vue';
import { getInitials } from '@/composable/useInitials';
import UserMenuContent from '@/components/UserMenuContent.vue';

type Props = {
    breadcrumbs?: BreadcrumbItem[];
    mainNavItems?: NavItem[];
};
const { isCurrentUrl, whenCurrentUrl } = useCurrentUrl();
const activeItemStyles =
    'text-neutral-900 dark:bg-neutral-800 dark:text-neutral-100';

const props = withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
    mainNavItems: () => [],
});

const page = usePage();
const auth = computed(() => page.props.auth);

const mainNavItems: NavItem[] = [
     {
        title: 'Home',
        href: "/",
        icon: Home,
    },
];

const rightNavItems: NavItem[] = [
    {
        title: 'Login',
        href: login(),
        icon: User2,
    },
];
</script>

<template>
    <div>
        <div class="border-b border-sidebar-border/80">
            <div class="mx-auto flex h-16 items-center px-4 md:max-w-7xl">
                <Link :href="home()" class="flex items-center gap-x-2">
                    <AppLogo />
                </Link>
                <div class="hidden h-full lg:flex lg:flex-1">
                    <NavigationMenu class="ml-10 flex h-full items-stretchS">
                        <NavigationMenuList class="flex h-full items-stretch space-x-2">
                            <NavigationMenuItem
                                v-for="(item, index) in props.mainNavItems"
                                :key="index"
                                class="relative flex h-full items-center"
                            >
                                <Link
                                    :class="[
                                        navigationMenuTriggerStyle(),
                                        whenCurrentUrl(
                                            item.href,
                                            activeItemStyles,
                                        ),
                                        'h-9 cursor-pointer px-3',
                                    ]"
                                    :href="item.href"
                                >
                                    <component
                                        v-if="item.icon"
                                        :is="item.icon"
                                        class="mr-2 h-4 w-4"
                                    />
                                    {{ item.title }}
                                </Link>
                                <div
                                    v-if="isCurrentUrl(item.href)"
                                    class="absolute bottom-0 left-0 h-0.5 w-full translate-y-px bg-black dark:bg-white"
                                ></div>
                            </NavigationMenuItem>
                            
                        </NavigationMenuList>
                    </NavigationMenu>
                </div>
                
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
        <slot />
    </div>
</template>
