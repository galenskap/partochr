<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <BreezeGuestLayout>
        <Head title="Mot de passe oublié" />

        <div class="">
            Entrez votre adresse e-mail pour qu'on vous envoie un lien de réinitialisation de votre mot de passe.
        </div>

        <div v-if="status" class="">
            {{ status }}
        </div>

        <BreezeValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
            <div class="field">
                <BreezeLabel for="email" value="Email" />
                <BreezeInput id="email" type="email" class="" v-model="form.email" required autofocus autocomplete="username" />
            </div>

            <div class="actions">
                <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Envoyez-moi le lien
                </BreezeButton>
            </div>
        </form>
    </BreezeGuestLayout>
</template>

<style scoped>
.field {
    margin-top: 2em;
}
</style>
