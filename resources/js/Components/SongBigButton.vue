<script setup>
import { Link } from '@inertiajs/inertia-vue3';

defineProps({
    id: {
        type: Number,
    },
    title: {
        type: String,
    },
    year: {
        type: Number,
    },
    artist: {
        type: String,
    },
});
</script>

<template>
    <Link :href="'/songs/'+id" class="song-big-button">
        <span class="name">{{ title }}</span>
        <span class="details">{{ artist }}, {{ year }}</span>
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
