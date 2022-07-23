<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import SongSmallButton from '@/Components/SongSmallButton.vue';

defineProps(['artist']);
</script>

<template>
    <Head :title="'Artiste - '+artist.name" />

    <BreezeAuthenticatedLayout>
        <section class="title">
            <h2>Artiste : {{ artist.name }}</h2>
            <!-- edit button -->
        </section>


        <section class="songs">
            <ul class="songlist">
                <li v-for="song in artist.songs" :key="song.id">
                    <SongSmallButton :id="song.id" :song="song"/>
                </li>
            </ul>
            <!-- bouton "+" (ajout chanson existante [search] ou nouvelle [form]) -->
        </section>

    </BreezeAuthenticatedLayout>
</template>

<style scoped>
.songlist {
    list-style: none;
    padding: 0;
}
</style>
