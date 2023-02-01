<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import TagFav from '@/Components/TagFav.vue';

const props = defineProps({
    tag: {
        type: Object,
    },
    displayFav: {
        type: Boolean,
    },
});
</script>

<template>
    <li>
        <Link :href="'/tags/'+tag.id" class="tag-big-button">
            <span class="name">{{ tag.name }}</span>
            <span class="nb-songs">{{ tag.songs_count }} {{ tag.songs_count > 1 ? "chansons" : "chanson" }}</span>
        </Link>
        <TagFav v-if="displayFav" :tag="tag" />
    </li>
</template>

<style scoped>
    .taglist li {
        display: flex;
        flex-direction: row;
        margin-bottom: .5em;
    }
    .tag-big-button {
        display: flex;
        flex-direction: column;
        padding: 0.5em 1em;
        border-radius: 3px;
        background-color: var(--tagColor);
        color: var(--white);
        cursor: pointer;
        transition: ease-in-out .2s;
        text-decoration: none;
        width: 100%;
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
