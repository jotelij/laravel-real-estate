<script setup lang="ts">
import { Form, Head, useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { login, register } from '@/routes';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { NativeSelect, NativeSelectOption } from '@/components/ui/native-select';


const form = useForm({
    name: '',
    role: '',
    email: '',
    password: '',
    password_confirmation: '',
});

function handleForm() {
    form.post(register().url, {
        onFinish: () => form.reset('password', 'password_confirmation'),
        // onSuccess: () => form.reset('password', 'password_confirmation'),
    }); 
}
</script>

<template>
    <AuthLayout
        title="Create an account"
        description="Enter your details below to create your account"
    >
        <Head title="Register" />
        
        <Form
            class="flex flex-col gap-6"
            @submit.prevent="handleForm"
        >
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="name">Name</Label>
                    <Input
                        v-model="form.name"
                        id="name"
                        type="text"
                        autofocus
                        :tabindex="1"
                        autocomplete="name"
                        name="name"
                        placeholder="Full name"
                        required
                    />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="role">Role</Label>
                    <NativeSelect 
                        v-model="form.role"
                        :aria-invalid="form.errors.role ? 'true' : 'false'"
                        name="role" 
                        id="role" 
                        autocomplete="role" 
                        :tabindex="2" 
                        class="w-100"
                        required
                        >
                            <NativeSelectOption value="">
                            Select role
                            </NativeSelectOption>
                            <NativeSelectOption value="2">
                            Agent
                            </NativeSelectOption>
                            <NativeSelectOption value="3">
                            Customer
                            </NativeSelectOption>
                    </NativeSelect>
                    <InputError :message="form.errors.role" />
                </div>

                <div class="grid gap-2">
                    <Label for="email">Email address</Label>
                    <Input
                        v-model="form.email"
                        id="email"
                        type="email"
                        :tabindex="3"
                        autocomplete="email"
                        name="email"
                        placeholder="email@example.com"
                        required
                    />
                    <InputError :message="form.errors.email" />
                </div>

                <div class="grid gap-2">
                    <Label for="password">Password</Label>
                    <PasswordInput
                        v-model="form.password"
                        id="password"
                        :tabindex="4"
                        autocomplete="new-password"
                        name="password"
                        placeholder="Password"
                        required
                    />
                    <InputError :message="form.errors.password" />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation">Confirm password</Label>
                    <PasswordInput 
                        v-model="form.password_confirmation"
                        id="password_confirmation"
                        :tabindex="5"
                        autocomplete="new-password"
                        name="password_confirmation"
                        placeholder="Confirm password"
                        required
                    />
                    <InputError :message="form.errors.password_confirmation" />
                </div>

                <div class=" text-sm text-muted-foreground">
                    By createing an account, you agree to our
                    <TextLink
                        href="#"
                        class="underline underline-offset-4"
                        :tabindex="6">Service and Privacy Policy</TextLink>.
                </div>

                <Button
                    type="submit"
                    class="mt-2 w-full"
                    tabindex="6"
                    :disabled="form.processing"
                    data-test="register-user-button"
                >
                    <Spinner v-if="form.processing" />
                    Create account
                </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground">
                Already have an account?
                <TextLink
                    :href="login()"
                    class="underline underline-offset-4"
                    :tabindex="7"
                    >Log in</TextLink
                >
            </div>
        </Form>
    </AuthLayout>
</template>
