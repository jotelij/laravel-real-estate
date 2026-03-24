<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';

import { Form, Link, useForm } from '@inertiajs/vue3';
import profile from '@/routes/profile';
import { UserMinus2 } from 'lucide-vue-next';
import { ref } from 'vue';

    
const accountForm = useForm({
    password: '',
});

const showConfirmPassword = ref(false)

const submitHandler = () => {
    accountForm.delete(profile.destroy.url(), {
        onFinish: () => accountForm.reset(),
        preserveScroll: true,
    });
}
</script>
<template>
    <Card>
        <CardHeader>
            <CardTitle>Delete Account</CardTitle>
            <CardDescription v-if="!showConfirmPassword">Do you want to delete your account? </CardDescription>
            <CardDescription v-else>This action is permanent and cannot be undone.. Please enter your password to confirm.</CardDescription>
        </CardHeader>
        <CardContent>
            <Button
                v-if="!showConfirmPassword"
                variant="default" 
                class="mb-4" 
                :disabled="accountForm.processing" 
                @click="showConfirmPassword = true"
                >
                <UserMinus2 /> Delete Account
            </Button>
            <div v-if="showConfirmPassword">
                <Form 
                    @submit.prevent="submitHandler"
                    class="auto-rows-min gap-6 space-y-6 grid grid-cols-1 md:grid-cols-2 items-center justify-center">

                    <div class="grid gap-2">
                        <Label for="password">Password</Label>
                        <Input
                            v-model="accountForm.password"
                            id="password"
                            type="password"
                            name="password"
                            autofocus
                            :tabindex="1"
                            autocomplete="password"
                            placeholder="Password"
                        />
                        <InputError :message="accountForm.errors.password" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 items-center justify-center">
                        <div class="my-6 flex items-center justify-start">
                            <Button
                            
                                :disabled="accountForm.processing"
                                data-test="email-password-reset-link-button"
                            >
                                <Spinner v-if="accountForm.processing" />
                                Delete Account
                            </Button>
                        </div>

                        <Link
                            @click="showConfirmPassword = false"
                            class="items-center justify-center text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
                        >
                            Cancel
                        </Link>
                    </div>

                    
                </Form>
            </div>
        </CardContent>
    </Card>

</template>