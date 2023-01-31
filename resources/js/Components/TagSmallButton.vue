<script setup>
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    tag: {
        type: Object,
    },
});
</script>

<template>
    <Link :href="'/tags/'+tag.id" class="tag-small-button">
        <span class="name">{{ tag.name }}</span>
    </Link>
</template>

<style scoped>
    .tag-small-button {
        display: flex;
        padding: .25em .25em;
        border-radius: 3px;
        background-color: var(--tagColor);
        color: var(--darkThemeBg);
        cursor: pointer;
        margin-bottom: .5em;
        transition: ease-in-out .2s;
        text-decoration: none;
        margin-right: .5em;
    }
    .tag-small-button:hover {
        opacity: .8;
        transition: ease-in-out .2s;
    }
    .name {
        font-size: .7em;
    }
</style>
