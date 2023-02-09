<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import SongBigButton from '@/Components/SongBigButton.vue';
import Paginator from "@/Components/Paginator";

const props = defineProps({
    songs: {
        type: Object,
    },
});
</script>

<template>
    <Head title="Toutes les chansons" />

    <BreezeAuthenticatedLayout>
        <section class="title">
            <h2>Toutes les chansons</h2>
        </section>

        <section class="songs">
            <ul class="songlist">
                <SongBigButton v-for="song in songs.data" :key="song.id" :song="song" />
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
