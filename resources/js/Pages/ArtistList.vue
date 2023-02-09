<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import ArtistBigButton from '@/Components/ArtistBigButton.vue';
import Paginator from "@/Components/Paginator";

const props = defineProps({
    artists: {
        type: Object,
    },
});
</script>

<template>
    <Head title="Tous les artistes" />

    <BreezeAuthenticatedLayout>
        <section class="title">
            <h2>Tous les artistes</h2>
        </section>

        <section class="artists">
            <ul class="artistlist">
                <li v-for="artist in artists.data" :key="artist.id">
                    <ArtistBigButton :id="artist.id" :artist="artist" />
                </li>
            </ul>
        </section>

        <Paginator :paginator="artists" />
    </BreezeAuthenticatedLayout>
</template>

<style scoped>
.artistlist {
    list-style: none;
    padding: 0;
}
</style>
