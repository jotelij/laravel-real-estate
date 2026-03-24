<script setup lang="ts">
import { Link, router, usePage } from '@inertiajs/vue3';
import { ExternalLink, GalleryVerticalEnd, Home, LogOut, UserCog} from 'lucide-vue-next'
import {
  Sidebar,
  SidebarContent,
  SidebarFooter,
  SidebarGroup,
  SidebarGroupContent,
  SidebarGroupLabel,
  SidebarHeader,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
  SidebarRail,
} from '@/components/ui/sidebar';
import { useCurrentUrl } from '@/composable/useCurrentUrl';
import { home, logout } from '@/routes';
import type { NavItem } from '@/types';

type Props = {
  navItems?: NavItem[],
};

withDefaults(defineProps<Props>(), {
  navItems: () => [],
});

const page = usePage();
const user = page.props.auth.user;

const homeNav = {
  title: 'Home',
  href: home.url(),
  icon: Home,
}

const { isCurrentUrl } = useCurrentUrl();
const handleLogout = () => {
    router.flushAll();
};

</script>

<template>
  <Sidebar>
    <SidebarHeader>
      <SidebarMenu>
        <SidebarMenuItem>
          <SidebarMenuButton size="lg">
            <div
              class="flex aspect-square size-8 items-center justify-center rounded-lg bg-sidebar-primary text-sidebar-primary-foreground">
              <GalleryVerticalEnd class="size-4" />
            </div>
            <div class="grid flex-1 text-left text-sm leading-tight">
              <span class="truncate font-semibold">Laravel</span>
              <span class="truncate text-xs">Real estate</span>
            </div>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </SidebarHeader>
    
    <SidebarContent>
      <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>Main</SidebarGroupLabel>
        <SidebarGroupContent>
          <SidebarMenu>
            <SidebarMenuItem >
              <SidebarMenuButton
                as-child
                :tooltip="homeNav.title"
                >
                <a :href="homeNav.href" target="_blank">
                      <component :is="homeNav.icon" />
                      <span>{{ homeNav.title }}</span>
                      <ExternalLink class="size-3" />
                </a>
              </SidebarMenuButton>
            </SidebarMenuItem>
          </SidebarMenu>
          </SidebarGroupContent>
      </SidebarGroup>
      <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>Platform</SidebarGroupLabel>
        <SidebarGroupContent>
          <SidebarMenu>
            <SidebarMenuItem v-for="item in navItems" :key="item.title">
              <SidebarMenuButton
                  as-child
                  :is-active="isCurrentUrl(item.href)"
                        :tooltip="item.title"

                  >
                  <Link :href="item.href">
                      <component :is="item.icon" />
                      <span>{{ item.title }}</span>
                  </Link>
              </SidebarMenuButton>
            </SidebarMenuItem>
          </SidebarMenu>
        </SidebarGroupContent>
      </SidebarGroup>
    </SidebarContent>
    <SidebarFooter>
      <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>{{ user.name }}</SidebarGroupLabel>
        <SidebarGroupContent>
          <SidebarMenu>
            <SidebarMenuItem >
              <SidebarMenuButton
                as-child
                :tooltip="user.name"
                >
                <Link :href="homeNav.href" target="_blank">
                      <UserCog />
                      <span>Settings</span>
                </Link>
              </SidebarMenuButton>
            </SidebarMenuItem>
            <SidebarMenuItem >
              <SidebarMenuButton
                as-child
                :tooltip="user.name"
                >
                <Link
                  class="block w-full cursor-pointer"
                  :href="logout()"
                  @click="handleLogout"
                  as="button"
                  data-test="logout-button"
              >
                  <LogOut />
                  Log out
              </Link>
              </SidebarMenuButton>
            </SidebarMenuItem>
          </SidebarMenu>
          </SidebarGroupContent>
      </SidebarGroup>
    </SidebarFooter>
    <SidebarRail />
  </Sidebar>
</template>
