<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import SongBigButton from '@/Components/SongBigButton.vue';
import TagFav from '@/Components/TagFav.vue';

const props = defineProps({
    tag: {
        type: Object,
    },
    songs: {
        type: Array,
    }
});
</script>

<template>
    <Head :title="'Classeur - '+tag.name" />

    <BreezeAuthenticatedLayout>
        <section class="title">
            <h2>Classeur : {{ tag.name }}</h2>
            <TagFav :tag="tag" />
            <!-- edit button -->
        </section>


        <section class="songs">
            <ol class="songlist">
                <SongBigButton v-for="song in songs" :key="song.id" :song="song" />
            </ol>
            <!-- bouton "+" (ajout chanson existante [search] ou nouvelle [form]) -->
        </section>

    </BreezeAuthenticatedLayout>
</template>

<style scoped>
.title {
    display: flex;
}
</style>
