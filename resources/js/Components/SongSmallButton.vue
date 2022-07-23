<script setup>
import { Link } from '@inertiajs/inertia-vue3';

defineProps({
    song: {
        type: Object,
    },
});
</script>

<template>
    <Link :href="'/songs/'+song.id" class="song-small-button">
        <span class="name">{{ song.title }}</span>
    </Link>
</template>

<style scoped>
    .song-small-button {
        display: flex;
        padding: .25em .25em;
        border-radius: 3px;
        background-color: var(--songColor);
        color: var(--darkThemeBg);
        cursor: pointer;
        margin-bottom: .5em;
        transition: ease-in-out .2s;
        text-decoration: none;
        margin-right: .5em;
    }
    .song-small-button:hover {
        opacity: .8;
        transition: ease-in-out .2s;
    }
    .name {
        font-size: .7em;
    }
</style>
