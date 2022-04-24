<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeCheckbox from '@/Components/Checkbox.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <BreezeGuestLayout>
        <Head title="Connexion" />

        <BreezeValidationErrors class="" />

        <div v-if="status" class="">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <BreezeLabel for="email" value="Email" />
                <BreezeInput id="email" type="email" class="" v-model="form.email" required autofocus autocomplete="username" />
            </div>

            <div class="">
                <BreezeLabel for="password" value="Password" />
                <BreezeInput id="password" type="password" class="" v-model="form.password" required autocomplete="current-password" />
            </div>

            <div class="">
                <label class="flex items-center">
                    <BreezeCheckbox name="remember" v-model:checked="form.remember" />
                    <span class="">Remember me</span>
                </label>
            </div>

            <div class="">
                <Link v-if="canResetPassword" :href="route('password.request')" class="">
                    Forgot your password?
                </Link>

                <BreezeButton class="" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </BreezeButton>
            </div>
        </form>
    </BreezeGuestLayout>
</template>

<style scoped>

</style>
