<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import SongBigButton from '@/Components/SongBigButton.vue';
import Paginator from "@/Components/Paginator";

const props = defineProps({
    songs: {
        type: Object,
    },
    recents: {
        type: Boolean,
    }
});
</script>

<template>
    <Head title="Toutes les chansons" />

    <BreezeAuthenticatedLayout>
        <section class="title">
            <h2 v-if="recents === false">Toutes les chansons</h2>
            <h2 v-else>Dernières chansons mises à jour</h2>
        </section>

        <section class="songs">
            <ul class="songlist">
                <SongBigButton v-for="song in songs.data" :key="song.id" :song="song" :showLastUpdate="recents" />
            </ul>
        </section>

        <Paginator :paginator="songs" />
    </BreezeAuthenticatedLayout>
</template>

<style scoped>
.songlist {
    list-style: none;
    padding: 0;
}
</style>
