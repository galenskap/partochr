<script setup>
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    tag: {
        type: Object,
    },
    song: {
        type: Object,
    }
});

const updateTag = (tagId, event) => {
    axios.post('/songs/'+props.song.id+'/tags/update', {
        tag: props.tag.id,
    })
    .then(function (response) {
        // get current song's tags from response and update local store data
        props.song.tags = response.data.tags;
    })
    .catch(function (errors) {
        console.log(errors);
    });
}
</script>

<template>
    <Link :href="'/tags/'+tag.id" class="tag-small-button">
        <span class="name">{{ tag.name }}</span>
    </Link>
    <img class="delete" @click="updateTag" src="../../img/delete.svg" alt="Supprimer" />
</template>

<style>
    .tag-small-button {
        display: flex;
        padding: .25em .25em;
        border-radius: 3px;
        background-color: var(--tagColor);
        color: var(--darkThemeBg);
        cursor: pointer;
        margin: .5em 0;
        transition: ease-in-out .2s;
        text-decoration: none;
    }
    .tag-small-button:hover {
        opacity: .8;
        transition: ease-in-out .2s;
    }
    .delete {
        filter: invert(50%) sepia(100%) saturate(320%) hue-rotate(-30deg); /*kind of orange*/
        width: 1em;
        height: 1em;
        margin-right: .5em;
        cursor: pointer;
    }
    .name {
        font-size: .7em;
    }
</style>
