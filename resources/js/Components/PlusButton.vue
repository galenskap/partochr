<script setup>
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    model: String,
});

let label = (props.model == 'songs') ? "Nouvelle chanson" : "Nouveau classeur";
</script>

<template>
    <Link :href="'/'+model+'/new'" class="plus-button">
        <span class="sign">+ {{ label }}</span>
    </Link>
</template>

<style scoped>
    .plus-button {
        display: flex;
        flex-direction: column;
        padding: 0.5em 1em;
        border-radius: 3px;
        background-color: var(--darkGrey);
        color: var(--lightGrey);
        cursor: pointer;
        margin-bottom: .5em;
        transition: ease-in-out .2s;
        text-decoration: none;
        text-align: center;
    }
    .plus-button:hover {
        opacity: .8;
        transition: ease-in-out .2s;
    }
    .sign {
        font-size: .8em;
    }
</style>
