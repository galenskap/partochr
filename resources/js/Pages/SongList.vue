<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import SongBigButton from '@/Components/SongBigButton.vue';

defineProps(['songs']);
</script>

<template>
    <Head title="Toutes les chansons" />

    <BreezeAuthenticatedLayout>
        <section class="title">
            <h2>Toutes les chansons</h2>
        </section>

        <section class="songs">
            <ul class="songlist">
                <li v-for="song in songs" :key="song.id">
                    <SongBigButton :id="song.id" :song="song" />
                </li>
            </ul>
        </section>

    </BreezeAuthenticatedLayout>
</template>

<style scoped>
.songlist {
    list-style: none;
    padding: 0;
}
</style>
