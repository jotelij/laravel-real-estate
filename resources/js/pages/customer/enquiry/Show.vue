<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ChevronLeft, Send } from 'lucide-vue-next';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Textarea } from '@/components/ui/textarea';
import CustomerLayout from '@/layouts/CustomerLayout.vue';
import { getEnquiryStatusValue } from '@/lib/enum_utils';
import { timeAgo, cn } from '@/lib/utils';
import enquiries from '@/routes/customer/enquiries';
import type { Enquiry, Message } from '@/types';

interface Props {
  enquiry: Enquiry;
}

const props = defineProps<Props>();

const messageForm = useForm({
    body: '',
});

const statusValue = getEnquiryStatusValue(props.enquiry.status);

const handleSendMessage = async () => {
    messageForm.post(enquiries.messages.store.url(props. enquiry.id), {
        preserveScroll: true,
        onSuccess: () => {
            messageForm.reset();
        },
    });
};

const isCurrentUserSender = (message: Message) => {
  return message.sender_id === props.enquiry.sender_id;
};
</script>

<template>
    <Head title="Enquiry" />
  
  <CustomerLayout>
    <div class="flex flex-1 flex-col gap-0">
      <!-- Header with back button -->
      <div class="border-b bg-background sticky top-0 z-10">
        <div class="flex items-center gap-4 p-4">
          <Link :href="enquiries.index.url()">
            <Button variant="ghost" size="icon" class="h-8 w-8">
              <ChevronLeft class="h-4 w-4" />
            </Button>
          </Link>
          <div class="flex-1">
            <h1 class="text-lg font-semibold">{{ enquiry.subject }}</h1>
            <p class="text-sm text-muted-foreground">
              {{ enquiry.property?.title }} • {{ timeAgo(enquiry.created_at) }}
            </p>
          </div>
          <Badge :class="statusValue.badgeClass">
            {{ statusValue.label }}
          </Badge>
        </div>
      </div>

      <!-- Enquiry Details -->
      <div class="border-b bg-muted/30 p-4">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
          <div>
            <p class="text-xs font-semibold text-muted-foreground uppercase">Property</p>
            <p class="text-sm font-medium mt-1">{{ enquiry.property?.title }}</p>
            <p class="text-xs text-muted-foreground">{{ enquiry.property?.address?.full_address }}</p>
          </div>
          <div>
            <p class="text-xs font-semibold text-muted-foreground uppercase">Agent</p>
            <p class="text-sm font-medium mt-1">{{ enquiry.agent?.name }}</p>
            <p class="text-xs text-muted-foreground">{{ enquiry.agent?.agent_profile?.agency_name }}</p>
          </div>
          <div>
            <p class="text-xs font-semibold text-muted-foreground uppercase">Initial Message</p>
            <p class="text-sm mt-1 line-clamp-2">{{ enquiry.message }}</p>
          </div>
          <div>
            <p class="text-xs font-semibold text-muted-foreground uppercase">Messages</p>
            <p class="text-sm font-medium mt-1">{{ enquiry.messages.length }} message(s)</p>
          </div>
        </div>
      </div>

      <!-- Messages Thread -->
      <div class="flex-1 overflow-y-auto p-4 space-y-4">
        <div v-if="enquiry.messages.length === 0" class="flex items-center justify-center h-32 text-muted-foreground">
          <p>No messages yet. Start the conversation below.</p>
        </div>

        <template v-for="(message) in enquiry.messages" :key="message.id">
          <div :class="cn('flex gap-3 animate-fade-in', isCurrentUserSender(message) ? 'flex-row-reverse' : '')">
            <!-- Avatar placeholder -->
            <div :class="cn('h-8 w-8 rounded-full flex items-center justify-center flex-shrink-0 text-xs font-semibold', isCurrentUserSender(message) ? 'bg-primary text-primary-foreground' : 'bg-secondary text-secondary-foreground')">
              {{ message.sender?.name?.charAt(0).toUpperCase() ?? 'U' }}
            </div>

            <!-- Message bubble -->
            <div :class="cn('flex flex-col max-w-md', isCurrentUserSender(message) ? 'items-end' : 'items-start')">
              <div :class="cn('px-4 py-2 rounded-lg', isCurrentUserSender(message) ? 'bg-primary text-primary-foreground rounded-br-none' : 'bg-muted text-foreground rounded-bl-none')">
                <p class="text-sm">{{ message.body }}</p>
              </div>
              <div class="flex items-center gap-2 mt-1 px-2">
                <span class="text-xs text-muted-foreground">{{ message.sender?.name }}</span>
                <span class="text-xs text-muted-foreground">{{ timeAgo(message.created_at) }}</span>
                <span v-if="message.read_at" class="text-xs text-muted-foreground">✓</span>
              </div>
            </div>
          </div>
        </template>
      </div>

      <!-- Message Input -->
      <div class="border-t bg-background p-4 sticky bottom-0">
        <form @submit.prevent="handleSendMessage" class="flex gap-2">
          <Textarea
            v-model="messageForm.body"
            placeholder="Type your message..."
            class="resize-none max-h-24"
            :disabled="messageForm.processing || statusValue.value == 3"
            @keydown.enter.ctrl.exact="handleSendMessage"
          />
          <Button
            type="submit"
            size="icon"
            :disabled="!messageForm.body.trim() || messageForm.processing || statusValue.value == 3"
            class="flex-shrink-0"
          >
            <Send class="h-4 w-4" />
          </Button>
        </form>
      </div>
    </div>
  </CustomerLayout>
</template>

<style scoped>
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in {
  animation: fadeIn 0.3s ease-out;
}
</style>
