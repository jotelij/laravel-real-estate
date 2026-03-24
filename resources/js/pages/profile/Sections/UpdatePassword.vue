<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';

import { Form, useForm } from '@inertiajs/vue3';
import profile from '@/routes/profile';

    
const accountForm = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});


const submitHandler = () => {
    accountForm.put(profile.password.url(), {
        onSuccess: () =>accountForm.reset(),
        onError: () => accountForm.reset(),
        preserveScroll: true,
    });
}
</script>
<template>
    <Card>
        <CardHeader>
            <CardTitle>Update Password</CardTitle>
            <CardDescription>Update your account password below.</CardDescription>
        </CardHeader>
        <CardContent>
            <Form 
                @submit.prevent="submitHandler"
                class="auto-rows-min gap-6 space-y-6">

                <div class="grid gap-2">
                    <Label for="current_password">Current Password</Label>
                    <Input
                        v-model="accountForm.current_password"
                        id="current_password"
                        type="password"
                        name="current_password"
                        autofocus
                        :tabindex="1"
                        autocomplete="current-password"
                        placeholder="Current Password"
                    />
                    <InputError :message="accountForm.errors.current_password" />
                </div>

                <div class="grid gap-2">
                    <Label for="password">New Password</Label>
                    <Input
                        v-model="accountForm.password"
                        id="password"
                        type="password"
                        name="password"
                        autofocus
                        :tabindex="1"
                        autocomplete="new-password"
                        placeholder="New Password"
                    />
                    <InputError :message="accountForm.errors.password" />
                </div>
                
                <div class="grid gap-2">
                    <Label for="password_confirmation">Confirm Password</Label>
                    <Input
                        v-model="accountForm.password_confirmation"
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        autofocus
                        :tabindex="1"
                        autocomplete="new-password"
                        placeholder="Confirm Password"
                    />
                    <InputError :message="accountForm.errors.password_confirmation" />
                </div>

                <div class="my-6 flex items-center justify-start">
                    <Button
                        :disabled="accountForm.processing"
                        data-test="email-password-reset-link-button"
                    >
                        <Spinner v-if="accountForm.processing" />
                        Update Password
                    </Button>
                </div>
            </Form>
        </CardContent>
    </Card>

</template>