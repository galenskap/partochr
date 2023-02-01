<script setup>
import { computed, reactive, ref } from "vue";
import { Head, Link, usePage, useForm } from '@inertiajs/inertia-vue3';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import TagSmallButton from '@/Components/TagSmallButton.vue';
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.bubble.css';
import axios from 'axios';

const user = computed(() => usePage().props.value.auth.user);
let isEditing = ref(false);
let editor = ref();
let searchresults = ref();

const form = useForm({
    title: '',
    artist: '',
    year: '',
    lyrics: '',
});

const toggleEditMode = () => {
    // if the user was editing
    // we need to go back to the inital state values for the lyrics!
    if(isEditing) {
        editor.pasteHTML(form.lyrics, 'api');
        form.reset();
    }

    isEditing.value = !isEditing.value;
    editor.enable(isEditing.value);
}

const getEditor = (quill) => {
    editor = quill;
    editor.enable(true);
    // initiate state value in order to easily go back
    form.lyrics = editor.root.innerHTML;
}

const sendModifications = () => {
    // if the user clicked on the save button
    // I transform simple spaces into unbreakable, in order to keep the real spaces between chords
    form.lyrics = editor.root.innerHTML.replace(/  /g," &nbsp;");

    // then we need to send all the new data to the backend!
    console.log('sending data...');

    form.post('/songs/new', {
        onSuccess: (response) => {
            isEditing.value = false;
            editor.enable(false);
        }
    });
}

const autocomplete = (event) => {
    let searchterm = event.target.value;
    if (searchterm.length > 2) {
        axios.post('/search-artist', {
            search: searchterm,
        })
        .then(function (response) {
            searchresults.value = response.data.artists;
        })
        .catch(function (errors) {
            console.log(errors);
        });
    } else {
        // empty suggestions
        searchresults.value = null;
    }
}
const chooseArtist = (event) => {
    let choosenOne = event.target.textContent;
    form.artist = choosenOne; // replace actual input content for the name
    // empty suggestions
    searchresults.value = null;
}
</script>



<template>
    <Head title="Nouvelle partoche" />

    <BreezeAuthenticatedLayout>

        <h1>Nouvelle partoche</h1>

        <section class="title">
            <label for="title">Titre de la chanson :</label>
            <input type="text" name="title" class="titleEdit" v-model="form.title" />

            <div class="song-details editing">
                <div class="artist-wrapper">
                    <label for="artist">Artiste ou groupe :</label>
                    <input type="text" name="artist" class="artistEdit" @keyup="autocomplete" v-model="form.artist" />
                    <ul v-if="searchresults" class="searchresults">
                        <li v-for="result in searchresults" :key="result.id" @click="chooseArtist">{{ result.name }}</li>
                    </ul>
                </div>

                <label for="artist">Année de publication :</label>
                <input type="text" name="year" class="yearEdit" v-model="form.year" />
            </div>
        </section>

        <section class="lyrics">
            <label for="lyrics">Paroles et accords :</label>
            <QuillEditor
                theme="bubble"
                toolbar="essential"
                contentType="html"
                preserveWhitespace="true"
                :content="form.lyrics"
                @ready="getEditor"
            />
            <textarea name="lyrics" style="display:none" v-model="form.lyrics"></textarea>
        </section>

        <button @click="sendModifications">
            <span>Enregistrer</span>
        </button>

    </BreezeAuthenticatedLayout>
</template>

<style scoped>
label {
    margin-top: 1em;
    display: block;
}
.titleEdit, .artistEdit, .yearEdit, .searchresults {
    width: 100%;
}
.lyrics {
    margin-top: 2em;
    white-space: pre-wrap;
}

.searchresults {
    padding: 0;
    margin: 0;
    list-style: none;
    background: rgba(255, 255, 255, .8);
    color: var(--songColor);
    border: 1px solid var(--songColor);
    position: relative;
    top: -.5em;
    box-sizing: border-box;
}
.searchresults li {
    font-size: .8em;
    padding: .5em .8em;
    font-style: italic;
    cursor: pointer;
}
</style>
