<script setup>
import { Link } from '@inertiajs/inertia-vue3';

defineProps({
    tag: {
        type: Object,
    },
});
</script>

<template>
    <Link :href="'/tags/'+tag.id" class="tag-big-button">
        <span class="name">{{ tag.name }}</span>
        <span class="nb-songs">{{ tag.nbSongs }} {{ tag.nbSongs > 1 ? "chansons" : "chanson" }}</span>
    </Link>
</template>

<style scoped>
    .tag-big-button {
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
    .tag-big-button:hover {
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
