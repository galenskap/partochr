<script setup>
import { computed, reactive, ref } from "vue";
import { Head, Link, usePage, useForm } from '@inertiajs/inertia-vue3';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import axios from 'axios';

const user = computed(() => usePage().props.value.auth.user);

const form = useForm({
    name: '',
});


const sendModifications = () => {
    console.log('sending data...');

    form.post('/tags/new', {
        onSuccess: (response) => {
            //TODO : redirect to tag page
        }
    });
}
</script>



<template>
    <Head title="Nouveau classeur" />

    <BreezeAuthenticatedLayout>

        <h1>Nouveau classeur</h1>

        <section class="title">
            <label for="name">Titre du classeur :</label>
            <input type="text" name="name" class="titleEdit" v-model="form.name" />
        </section>

        <button @click="sendModifications">
            <span>Enregistrer</span>
        </button>

    </BreezeAuthenticatedLayout>
</template>

<style scoped>
label {
    margin-top: 1em;
    display: block;
}
.titleEdit {
    width: 100%;
}
</style>
