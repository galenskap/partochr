<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { ref } from "vue";

const props = defineProps({
    song: {
        type: Object,
    },
});

const isShow = ref(false);
let searchQuery = ref();
let searchresults = ref();

function toggleModal() {
    isShow.value = !isShow.value;
}

const autocomplete = (event) => {
    let searchterm = event.target.value;
    if (searchterm.length > 2) {
        axios.post('/tags/search', {
            search: searchterm,
        })
        .then(function (response) {
            searchresults.value = new Array();
            // Keep only the tags that are not already in our song.tags
            response.data.tags.forEach(element => {
                if (!props.song.tags.some( (tag) => {
                    // do we have any tag already in song's tags list?
                    return element.id === tag.id;
                })) {
                    searchresults.value.push(element);
                }
            });
        })
        .catch(function (errors) {
            console.log(errors);
        });
    } else {
        // empty suggestions
        searchresults.value = null;
    }
}


const chooseTag = (tagId, event) => {
    axios.post('/songs/'+props.song.id+'/tags/update', {
        tag: tagId,
    })
    .then(function (response) {
        // get current song's tags from response and update local store data
        props.song.tags = response.data.tags;
        // empty suggestions
        searchresults.value = null;
        // empty search field
        searchQuery.value = "";
        // hide search area
        toggleModal();
    })
    .catch(function (errors) {
        console.log(errors);
    });
}
</script>

<template>
    <button class="tag-small-button plus" @click="toggleModal">
        <span class="name">+</span>
    </button>

    <div v-show="isShow" class="modal-container">
        <div class="modal-inner">
            <label for="tag">Ajouter cette chanson au classeur :</label>
            <input type="text" name="tag" v-model="searchQuery" class="tagAdd" @keyup="autocomplete"/>
            <ul v-if="searchresults" class="searchresults">
                <li v-for="result in searchresults" :key="result.id" @click="chooseTag(result.id, $event)">
                    <span class="tagname">{{ result.name }}</span>
                </li>
            </ul>
        </div>
    </div>
</template>


<style scoped>
    .modal-container {
        width: 100%;
    }
    .modal-container label {
        font-size: .8em;
        font-style: italic;
        margin-right: .8em;
    }
    .modal-container .tagAdd {
        width: 100%;
    }
    .searchresults {
        padding: 0;
        margin: 0;
        list-style: none;
        background: rgba(255, 255, 255, .8);
        border: 1px solid var(--songColor);
        position: relative;
        top: -.5em;
        box-sizing: border-box;
        color: var(--tagColor);
    }
    .searchresults li {
        font-size: .7em;
        padding: .5em .8em;
        font-style: italic;
        cursor: pointer;
    }
    .plus {
        background-color: var(--tagColor);
        color: var(--darkThemeBg);
        opacity: .5;
        width: auto;
        padding-left: .5em;
        padding-right: .5em;
    }
    .plus:hover {
        opacity: 1;
        transition: ease-in-out .2s;
    }
    .name {
        font-size: .7em;
    }
</style>
