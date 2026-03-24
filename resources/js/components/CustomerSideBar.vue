<script setup lang="ts">

import { Calendar, HouseHeart, LayoutDashboard, MessageSquareText, Settings } from 'lucide-vue-next'
import AppSidebar from './AppSidebar.vue';
import customer from '@/routes/customer';
import profile from '@/routes/profile';


// Menu items.
const navItems = [
  {
    title: 'Dashboard',
    href: customer.dashboard(),
    icon: LayoutDashboard,
  },
  {
    title: 'Favourites',
    href: customer.favourites(),
    icon: HouseHeart,
  },
  {
    title: 'Enquiries',
    href: customer.enquiries.index(),
    icon: MessageSquareText,
  },
  {
    title: 'Viewings',
    href: customer.viewings.index(),
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