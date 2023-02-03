<script setup>
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    tag: {
        type: Object,
    },
});

const updateTagFav = () => {
    axios.get('/tags/'+props.tag.id+'/users/update', {
        tag: props.tag.id,
    })
    .then(function (response) {
        // get current tag from response and update local store data
        props.tag.is_in_favourites = response.data.tag.is_in_favourites;
    })
    .catch(function (errors) {
        console.log(errors);
    });
}
</script>

<template>
    <img v-if="tag.is_in_favourites" class="star full" @click="updateTagFav" src="../../img/star.svg" alt="Enlever des favoris" />
    <img v-else class="star empty" @click="updateTagFav" src="../../img/star.svg" alt="Mettre en favori" />
</template>

<style scoped>
    .star {
        filter: invert(50%) sepia(100%) saturate(320%) hue-rotate(-30deg); /*kind of orange*/
        width: 2em;
        height: 2em;
        margin: auto .5em;
        cursor: pointer;
    }
    .theme-dark .star.empty {
        filter: invert(100%) opacity(20%);
    }
    .theme-light .star.empty {
        filter: invert(0%) opacity(20%);
    }
</style>
