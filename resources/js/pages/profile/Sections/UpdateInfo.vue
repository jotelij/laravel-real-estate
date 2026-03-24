<script setup lang="ts">
import { Form, Link, router, useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import profile from '@/routes/profile';
import verification from '@/routes/verification';
import type { User } from '@/types';


interface props {
    user: User;
    status?: string;

} 

const props = defineProps<props>();
    
const accountForm = useForm({
    name: props.user.name,
    email: props.user.email,
});

const resendEmail = (e: any) => {
    return router.post(
        verification.send.url(),
        {}, 
        {
        onStart: () => {
            e.target.disabled = true;
        },
        onFinish: () => {
            e.target.disabled = false;
        }
    });
}
</script>
<template>
    <Card>
        <CardHeader>
            <CardTitle>Update Account Information</CardTitle>
            <CardDescription>Update your account information below.</CardDescription>
        </CardHeader>
        <CardContent>
            <Form 
                @submit.prevent="accountForm.patch(profile.update.url())"
                class="auto-rows-min gap-6 space-y-4">
                <div class="grid gap-2">
                    <Label for="name">Name</Label>
                    <Input
                        v-model="accountForm.name"
                        id="name"
                        type="text"
                        name="name"
                        autofocus
                        :tabindex="1"
                        autocomplete="name"
                        placeholder="Your Name"
                    />
                    <InputError :message="accountForm.errors.name" />
                </div>
                
                <div class="grid gap-2">
                    <Label for="email">Email address</Label>
                    <Input
                        v-model="accountForm.email"
                        id="email"
                        type="email"
                        name="email"
                        autofocus
                        :tabindex="1"
                        autocomplete="email"
                        placeholder="email@example.com"
                    />
                    <InputError :message="accountForm.errors.email" />
                </div>

                <div
                    v-if="!user.email_verified_at" 
                    class="text-center text-sm font-medium text-muted-foreground"
                >
                    Your email isn't verified. Please check your inbox for a verification link.
                    <Link
                        @click="resendEmail"
                        class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
                    >
                        Click here to resend the verification email.
                    </Link>
                </div>

                <div class="my-6 flex items-center justify-start">
                    <Button
                   
                        :disabled="accountForm.processing"
                        data-test="email-password-reset-link-button"
                    >
                        <Spinner v-if="accountForm.processing" />
                        Update Information
                    </Button>
                </div>
            </Form>
        </CardContent>
    </Card>
   
</template>