<script setup>
import { Link } from '@inertiajs/inertia-vue3';

defineProps({
    artist: {
        type: Object,
    },
});
</script>

<template>
    <Link :href="'/artists/'+artist.id" class="artist-big-button">
        <span class="name">{{ artist.name }}</span>
        <span class="nb-songs">{{ artist.songs_count }} {{ artist.songs_count > 1 ? "chansons" : "chanson" }}</span>
    </Link>
</template>

<style scoped>
    .artist-big-button {
        display: flex;
        flex-direction: column;
        padding: 0.5em 1em;
        border-radius: 3px;
        background-color: var(--tagColor);
        color: var(--white);
        cursor: pointer;
        margin-bottom: .5em;
        transition: ease-in-out .2s;
        text-decoration: none;
    }
    .artist-big-button:hover {
        opacity: .8;
        transition: ease-in-out .2s;
    }
    .name {
        font-size: 1em;
    }
    .nb-songs {
        font-size: .8em;
    }
</style>
