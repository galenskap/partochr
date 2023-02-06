<script setup>
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    song: {
        type: Object,
    },
    isEditing: {
        type: Boolean,
    },
    chooseSong: {
        type: Function,
    }
});
</script>

<template>
    <li>
        <div class="container">
            <Link :href="'/songs/'+song.id" class="song-big-button">
                <span class="name">{{ song.title }}</span>
                <span class="details">{{ song.artist.name }}{{ song.year ? ", "+song.year : "" }}</span>
            </Link>
            <img class="delete" v-if="isEditing" @click="chooseSong(song, $event)" src="../../img/delete.svg" alt="Supprimer" />
        </div>
    </li>
</template>

<style scoped>
    .songlist .container {
        width: 100%;
    }
    .songs .songlist .container {
        display: flex;
    }
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
        width: 100%;
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
    .delete {
        filter: invert(50%) sepia(100%) saturate(320%) hue-rotate(140deg); /*kind of blue*/
        width: 2em;
        height: 2em;
        margin: auto .5em;
        cursor: pointer;
    }
</style>
