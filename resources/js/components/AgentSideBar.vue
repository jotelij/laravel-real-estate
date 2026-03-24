<script setup lang="ts">

import { Calendar, GalleryVerticalEnd, Home, Inbox, LayoutDashboard, LucideMapPinHouse, MessageSquareText, Search, Settings } from 'lucide-vue-next'
import AppSidebar from './AppSidebar.vue';
import agent from '@/routes/agent';
import profile from '@/routes/profile';


// Menu items.
const navItems = [
  {
    title: 'Dashboard',
    href: agent.dashboard(),
    icon: LayoutDashboard,
  },
  {
    title: 'Properties',
    href: agent.properties.index(),
    icon: LucideMapPinHouse,
  },
  {
    title: 'Enquiries',
    href: agent.enquiries.index(),
    icon: MessageSquareText,
  },
  {
    title: 'Viewings',
    href: agent.viewings.index(),
    icon: Calendar,
  },
  {
    title: 'Profile',
    href: profile.info(),
    icon: Settings,
  },
]
</script>

<template>
    <AppSidebar :navItems="navItems" />
</template>