<script setup>
import { computed, reactive, ref } from "vue";
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import TagSmallButton from '@/Components/TagSmallButton.vue';
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.bubble.css';
import axios from 'axios';

defineProps(['song']);

const user = computed(() => usePage().props.value.auth.user);
let isEditing = ref(false);
let lyrics = ref();
let editor = ref();

const toggleEditMode = () => {
    // if the user was editing
    // we need to go back to the inital state values for the lyrics!
    if(isEditing)
        editor.pasteHTML(lyrics.value, 'api');
    isEditing.value = !isEditing.value;
    editor.enable(isEditing.value);
}

const getEditor = (quill) => {
    editor = quill;
    editor.enable(false);
    lyrics.value = editor.root.innerHTML; // initiate state value in order to easily go back
}

const sendModifications = (sid) => {
    // if the user clicked on the save button
    // I transform simple spaces into unbreakable, in order to keep the real spaces between chords
    lyrics.value = editor.root.innerHTML.replace(/  /g," &nbsp;");

    // then we need to send all the new data to the backend!
    console.log('sending data...');

    axios.post('/songs/'+sid+'/edit', {
        id: sid,
        lyrics: lyrics.value,
    })
    .then(function (response) {
        isEditing.value = false;
        editor.enable(false);
    })
    .catch(function (errors) {
        console.log(errors);
    });
}
</script>



<template>
    <Head :title="song.title" />

    <BreezeAuthenticatedLayout>
        <section class="title">
            <h2>{{ song.title }}</h2>
            <p class="song-details">{{ song.artist.name }}, {{ song.year }}</p>
            <!-- edit button -->
            <button v-if="user.id == song.user_id" @click="toggleEditMode()">
                <span v-if="isEditing">Cancel!</span>
                <span v-else>Edit!</span>
            </button>
        </section>

        <section class="tags subpart">
            <h3>Classeurs :</h3>
            <ul class="taglist">
                <TagSmallButton v-for="tag in song.tags" :key="tag.id" :tag="tag" />
            </ul>
            <!-- bouton "+" (ajout tag existant [search] ou nouveau [form]) -->
        </section>

        <section class="lyrics">
            <QuillEditor
                theme="bubble"
                toolbar="essential"
                contentType="html"
                preserveWhitespace="true"
                :content="song.lyrics"
                @ready="getEditor" />
        </section>

        <button v-if="isEditing" @click="sendModifications(song.id)">
            <span>Enregistrer</span>
        </button>

    </BreezeAuthenticatedLayout>
</template>

<style scoped>
.taglist {
    padding: 0;
    display: flex;
    margin-top: 0;
}
.title {
    margin-bottom: 2em;
}
.title h2 {
    margin-bottom: .1em;
}
.title .song-details {
    font-weight: lighter;
    font-style: italic;
    margin: 0;
    font-size: .9em;
}
.lyrics {
    margin-top: 3em;
    white-space: pre-wrap;
}
.ql-toolbar {
    white-space: normal;
}
</style>
