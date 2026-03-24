<script setup lang="ts">
import { Form, Head, useForm } from '@inertiajs/vue3';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Spinner } from '@/components/ui/spinner';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { logout } from '@/routes';
import verification from '@/routes/verification';

defineProps<{
    status?: string;
}>();

const resendForm = useForm();

const onSubmitResend = () => {
    resendForm.post(verification.send().url);
};
</script>

<template>
    <AuthLayout
        title="Verify email"
        description="Please verify your email address by clicking on the link we just emailed to you."
    >
        <Head title="Email verification" />

        <div
            v-if="status === 'verification-link-sent'"
            class="mb-4 text-center text-sm font-medium text-green-600"
        >
            A new verification link has been sent to the email address you
            provided during registration.
        </div>

        <Form
            class="space-y-6 text-center"
            @submit.prevent="onSubmitResend">
            <Button :disabled="resendForm.processing" variant="secondary">
                <Spinner v-if="resendForm.processing" />
                Resend verification email
            </Button>

            <TextLink
                :href="logout()"
                as="button"
                class="mx-auto block text-sm"
            >
                Log out
            </TextLink>
        </Form>
    </AuthLayout>
</template>
