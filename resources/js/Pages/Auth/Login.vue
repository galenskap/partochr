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
            <div class="field email">
                <BreezeLabel for="email" value="Email" />
                <BreezeInput id="email" type="email" class="" v-model="form.email" required autofocus autocomplete="username" />
            </div>

            <div class="field pwd">
                <BreezeLabel for="password" value="Password" />
                <BreezeInput id="password" type="password" class="" v-model="form.password" required autocomplete="current-password" />
            </div>

            <div class="field remember">
                <label class="">
                    <BreezeCheckbox name="remember" v-model:checked="form.remember" />
                    <span class="">Se rappeler de moi</span>
                </label>
            </div>

            <div class="field actions">
                <BreezeButton class="login" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Se connecter
                </BreezeButton>

                <Link v-if="canResetPassword" :href="route('password.request')" class="forgot">
                    Mot de passe oublié
                </Link>
            </div>
        </form>
    </BreezeGuestLayout>
</template>

<style scoped>
.field {
    display: flex;
    flex-direction: column;
    margin-bottom: .5em;
}
.field label {
    color: var(--tagColor);
}
.field input {
    padding: .5em;
    font-size: .8em;
    margin: .5em 0;
    border: 1px solid var(--tagColor);
}
.field.pwd {
    margin-bottom: 0;
}
.remember, .forgot {
    font-size: .75em;
}
.remember {
    text-align: right;
    font-style: italic;
}
.remember input {
    margin-right: .8em;
    font-size: .6em;
}
.actions {
    text-align: center;
    margin-top: 2em;
}
.forgot {
    margin-top: 1em;
}
</style>
