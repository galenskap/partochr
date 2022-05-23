<script setup>
defineProps({
    name: {
        type: String,
    },
    nbSongs: {
        type: Number,
    },
});
</script>

<template>
    <div class="tag-big-button">
        <span class="name">{{ name }}</span>
        <span class="nb-songs">{{ nbSongs }} {{ nbSongs > 1 ? "chansons" : "chanson" }}</span>
    </div>
</template>

<style scoped>
    .tag-big-button {
        display: flex;
        flex-direction: column;
        padding: 0.5em 1em;
        border-radius: 3px;
        background-color: var(--songColor);
        color: var(--white);
        cursor: pointer;
        margin-bottom: .5em;
        transition: ease-in-out .2s;
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
