<script setup lang="ts">
import AuthLayout from '@/layouts/AuthLayout.vue';
import { Form, Head, useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { login, register } from '@/routes';
import { Checkbox } from '@/components/ui/checkbox';
import password from '@/routes/password';

defineProps<{
    status?: string;
}>();

const loginForm = useForm({
    email: '',
    password: '',
    remember: false,
});

function handleLogin() {
    loginForm.post(login().url, {
        onFinish: () => {
            loginForm.reset('password');
        },
    });
}
</script>

<template>
     <AuthLayout
        title="Log in to your account"
        description="Enter your details below to log in to your account"
    >
        <Head title="Log in" />
         <div
            v-if="status"
            class="mb-4 text-center text-sm font-medium text-green-600"
        >
            {{ status }}
        </div>

        <Form
            @submit.prevent="handleLogin"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="email">Email address</Label>
                    <Input
                        v-model="loginForm.email"
                        id="email"
                        type="email"
                        name="email"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="email"
                        placeholder="email@example.com"
                    />
                    <InputError :message="loginForm.errors.email" />
                </div>

                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="password">Password</Label>
                        <TextLink
                            :href="password.request.url()"
                            class="text-sm"
                            :tabindex="5"
                        >
                            Forgot password?
                        </TextLink>
                    </div>
                    <PasswordInput
                        v-model="loginForm.password"
                        id="password"
                        name="password"
                        required
                        :tabindex="2"
                        autocomplete="current-password"
                        placeholder="Password"
                    />
                    <InputError :message="loginForm.errors.password" />
                </div>

                <div class="flex items-center justify-between">
                    <Label for="remember" class="flex items-center space-x-3">
                        <Checkbox v-model="loginForm.remember" id="remember" name="remember" :tabindex="3" />
                        <span>Remember me</span>
                    </Label>
                </div>

                <Button
                    type="submit"
                    class="mt-4 w-full"
                    :tabindex="4"
                    :disabled="loginForm.processing"
                    data-test="login-button"
                >
                    <Spinner v-if="loginForm.processing" />
                    Log in
                </Button>
            </div>

            <div
                class="text-center text-sm text-muted-foreground"
            >
                Don't have an account?
                <TextLink :href="register()" :tabindex="5">Sign up</TextLink>
            </div>
        </Form>
    </AuthLayout>
</template>