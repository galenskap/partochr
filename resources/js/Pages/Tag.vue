<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import SongBigButton from '@/Components/SongBigButton.vue';

defineProps(['tag', 'songs']);
</script>

<template>
    <Head :title="'Classeur - '+tag.name" />

    <BreezeAuthenticatedLayout>
        <section class="title">
            <h2>Classeur : {{ tag.name }}</h2>
            <!-- edit button -->
        </section>


        <section class="songs">
            <ol class="songlist">
                <li v-for="song in songs" :key="song.id">
                    <SongBigButton :id="song.id" :title="song.title" :artist="song.artist.name" :year="song.year" />
                </li>
            </ol>
            <!-- bouton "+" (ajout chanson existante [search] ou nouvelle [form]) -->
        </section>

    </BreezeAuthenticatedLayout>
</template>

<style scoped>
</style>
