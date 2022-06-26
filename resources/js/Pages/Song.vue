<script setup>
import { computed, reactive, ref } from "vue";
import { Head, Link, usePage, useForm } from '@inertiajs/inertia-vue3';
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

const form = useForm({
    title: usePage().props.value.song.title,
    artist: usePage().props.value.song.artist.name,
    year: usePage().props.value.song.year,
    lyrics: usePage().props.value.song.lyrics,
});

const toggleEditMode = () => {
    // if the user was editing
    // we need to go back to the inital state values for the lyrics!
    if(isEditing) {
        editor.pasteHTML(lyrics.value, 'api');
        form.reset();
    }

    isEditing.value = !isEditing.value;
    editor.enable(isEditing.value);
}

const getEditor = (quill) => {
    editor = quill;
    editor.enable(false);
    // initiate state value in order to easily go back
    lyrics.value = editor.root.innerHTML;
}

const sendModifications = (sid) => {
    // if the user clicked on the save button
    // I transform simple spaces into unbreakable, in order to keep the real spaces between chords
    form.lyrics = editor.root.innerHTML.replace(/  /g," &nbsp;");

    // then we need to send all the new data to the backend!
    console.log('sending data...');
    console.log(form);

    form.post('/songs/'+sid+'/edit', {

        onSuccess: (response) => {
            isEditing.value = false;
            editor.enable(false);
        }
    });
}
</script>



<template>
    <Head :title="song.title" />

    <BreezeAuthenticatedLayout>
        <section class="title">
            <h2>
                <input v-if="isEditing" type="text" name="title" class="titleEdit" v-model="form.title" />
                <span v-else>{{song.title}}</span>
            </h2>
            <p v-if="isEditing" class="song-details editing">
                <input type="text" name="artist" class="artistEdit" v-model="form.artist" />
                <input type="text" name="year" class="yearEdit" v-model="form.year" />
            </p>
            <p v-else class="song-details">{{ song.artist.name }}, {{ song.year }}</p>
            <!-- edit button -->
            <button v-if="user.id == song.user_id" @click="toggleEditMode()" class="editAction">
                <img v-if="isEditing" class="cancel" src="../../img/cancel.png" alt="Annuler" width="2em" height="2em" />
                <img v-else class="edit" src="../../img/edit.png" alt="Éditer" width="2em" height="2em" />
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
                @ready="getEditor"
            />
            <textarea name="lyrics" style="display:none" v-model="form.lyrics"></textarea>
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
.editAction {
    background: none;
    width: auto;
    position: absolute;
    right: .5em;
    top: 3em;
}
.editAction img {
    width: 2em;
    height: 2em;
}
.editAction .cancel {
    position: relative;
    top: .2em;
    right: .2em;
    width: 1.9em;
    height: 1.9em;
}
.titleEdit, .artistEdit, .yearEdit {
    width: 100%;
}
.artistEdit {
    margin-right: .5em;
}
.lyrics {
    margin-top: 3em;
    white-space: pre-wrap;
}
@media screen and (max-width: 768px) {
    .titleEdit, .artistEdit, .yearEdit {
        width: 8em;
    }
}
</style>
