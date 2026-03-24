<script setup lang="ts">

import { Calendar,  LayoutDashboard, LucideMapPinHouse, MessageSquareText, Settings } from 'lucide-vue-next'
import agent from '@/routes/agent';
import profile from '@/routes/profile';
import AppSidebar from './AppSidebar.vue';


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