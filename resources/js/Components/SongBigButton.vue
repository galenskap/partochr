<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import moment from 'moment';

const props = defineProps({
    song: {
        type: Object,
    },
    isEditing: {
        type: Boolean,
    },
    chooseSong: {
        type: Function,
    },
    showLastUpdate: {
        type: Boolean,
    }
});

const formatDate = (rawDate) => {
    if (rawDate) {
        return moment(String(rawDate)).format('DD/MM/YYYY');
    }
};
</script>

<template>
    <li :class="showLastUpdate ? 'recent' : 'normal'">
        <div class="container">
            <Link :href="'/songs/'+song.id" class="song-big-button big-button">
                <span class="name">{{ song.title }}</span>
                <span class="details">{{ song.artist.name }}{{ song.year ? ", "+song.year : "" }}</span>
            </Link>
            <img class="delete" v-if="isEditing" @click="chooseSong(song, $event)" src="../../img/delete.svg" alt="Supprimer" />
        </div>
        <span class="last-update" v-if="showLastUpdate">Mis à jour le {{ formatDate(song.updated_at) }} par {{ song.user.name }}</span>
    </li>
</template>

<style scoped>
    .songlist .container {
        width: 100%;
    }
    .songs .songlist .container {
        display: flex;
    }
    .songs .songlist li.recent {
        display: flex;
        flex-direction: column;
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
    .last-update {
        font-size: .65em;
        font-style: italic;
        margin-bottom: 1.4em;
        margin-top: -.2em;
    }
</style>
