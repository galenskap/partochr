<script setup>
import { Link } from '@inertiajs/inertia-vue3';

defineProps({
    song: {
        type: Object,
    },
});
</script>

<template>
    <Link :href="'/songs/'+song.id" class="song-big-button">
        <span class="name">{{ song.title }}</span>
        <span class="details">{{ song.artist.name }}, {{ song.year }}</span>
    </Link>
</template>

<style scoped>
    .song-big-button {
        display: flex;
        flex-direction: column;
        padding: 0.5em 1em;
        border-radius: 3px;
        background-color: var(--songColor);
        color: var(--white);
        cursor: pointer;
        margin-bottom: .5em;
        transition: ease-in-out .2s;
        text-decoration: none;
    }
    .song-big-button:hover {
        opacity: .8;
        transition: ease-in-out .2s;
    }
    .name {
        font-size: 1em;
    }
    .details {
        font-size: .8em;
    }
</style>
