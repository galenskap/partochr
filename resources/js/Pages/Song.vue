<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import TagSmallButton from '@/Components/TagSmallButton.vue';

defineProps(['song']);
</script>

<template>
    <Head :title="song.title" />

    <BreezeAuthenticatedLayout>
        <section class="title">
            <h2>{{ song.title }}</h2>
            <p class="song-details">{{ song.artist.name }}, {{ song.year }}</p>
            <!-- edit button -->
        </section>

        <section class="tags subpart">
            <h3>Classeurs :</h3>
            <ul class="taglist">
                <TagSmallButton v-for="tag in song.tags" :key="tag.id" :id="tag.id" :name="tag.name" />
            </ul>
            <!-- bouton "+" (ajout tag existant [search] ou nouveau [form]) -->
        </section>

        <section class="lyrics">
            {{ song.lyrics }}
        </section>

    </BreezeAuthenticatedLayout>
</template>

<style scoped>
.taglist {
    padding: 0;
    display: flex;
    margin-top: 0;
}
.title {
    margin-bottom: 2em;
}
.title h2 {
    margin-bottom: .1em;
}
.title .song-details {
    font-weight: lighter;
    font-style: italic;
    margin: 0;
    font-size: .9em;
}
.lyrics {
    font-size: .7em;
    margin-top: 3em;
}
</style>
