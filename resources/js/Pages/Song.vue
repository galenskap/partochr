<script setup>
import { computed, reactive, ref } from "vue";
import { Head, Link, usePage, useForm } from '@inertiajs/inertia-vue3';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import TagSmallButton from '@/Components/TagSmallButton.vue';
import PlusTagButtonModal from '@/Components/PlusTagButtonModal.vue';
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.bubble.css';
import axios from 'axios';
import moment from 'moment';

const props = defineProps({
    song: {
        type: Object,
    },
});

const user = computed(() => usePage().props.value.auth.user);
let isEditing = ref(false);
let editor = ref();
let searchresults = ref();
moment.locale('fr'); 

const form = useForm({
    title: props.song.title,
    artist: props.song.artist.name,
    year: props.song.year,
    lyrics: props.song.lyrics,
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
    editor.enable(false);
    // initiate state value in order to easily go back
    form.lyrics = editor.root.innerHTML;
}

const sendModifications = (sid) => {
    // if the user clicked on the save button
    // I transform simple spaces into unbreakable, in order to keep the real spaces between chords
    form.lyrics = editor.root.innerHTML.replace(/  /g," &nbsp;");

    // then we need to send all the new data to the backend!
    console.log('sending data...');

    form.post('/songs/'+sid+'/edit', {
        onSuccess: (response) => {
            isEditing.value = false;
            editor.enable(false);
        }
    });
}

const sendDelete = (songId) => {
    if (confirm("Voulez-vous vraiment supprimer cette chanson ?")) {
        axios.delete('/songs/' + songId)
            .then((response) => {
                isEditing.value = false;
                toast(response.data.message, 'success');
                window.location = route('home'); // redirect to home
            });
    }
}

const autocomplete = (event) => {
    let searchterm = event.target.value;
    if (searchterm.length > 2) {
        axios.post('/artists/search', {
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
    <Head :title="song.title" />

    <BreezeAuthenticatedLayout>
        <section class="title">
            <h2>
                <label v-if="isEditing" for="title">Titre de la chanson * :</label>
                <input v-if="isEditing" type="text" name="title" class="titleEdit" v-model="form.title" />
                <span v-else>{{song.title}}</span>
            </h2>
            <div v-if="isEditing" class="song-details editing">
                <div class="artist-wrapper">
                    <label for="artist">Artiste ou groupe * :</label>
                    <input type="text" name="artist" class="artistEdit" @keyup="autocomplete" v-model="form.artist" />
                    <ul v-if="searchresults" class="searchresults">
                        <li v-for="result in searchresults" :key="result.id" @click="chooseArtist">{{ result.name }}</li>
                    </ul>
                </div>

                <label for="artist">Année de publication :</label>
                <input type="text" name="year" class="yearEdit" v-model="form.year" />
            </div>
            <p v-else class="song-details"><Link :href="'/artists/'+song.artist.id">{{ song.artist.name }}</Link>{{ song.year ? ", "+song.year : "" }}</p>
            
            <div class="last-updated">
                Dernière mise à jour : par {{ song.user.name }} {{ moment(song.updated_at).fromNow() }}.
            </div>

            <button v-if="user.id == song.user_id" @click="toggleEditMode()" class="editAction">
                <img v-if="isEditing" class="cancel" src="../../img/cancel.png" alt="Annuler" width="2em" height="2em" />
                <img v-else class="edit" src="../../img/edit.png" alt="Éditer" width="2em" height="2em" />
            </button>
        </section>

        <section class="tags subpart">
            <h3>Classeurs :</h3>
            <ul class="taglist">
                <TagSmallButton v-for="tag in song.tags" :key="tag.id" :tag="tag" :song="song" :isEditing="isEditing" />
                <PlusTagButtonModal v-if="isEditing" :song="song" />
            </ul>
        </section>

        <section class="lyrics">
            <label v-if="isEditing" for="lyrics">Paroles et accords :</label>
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

        <div class="actions" v-if="isEditing">
            <button @click="sendDelete(song.id)" class="remove">
                <span>Supprimer</span>
            </button>
            <button @click="sendModifications(song.id)" class="send">
                <span>Enregistrer</span>
            </button>
        </div>

    </BreezeAuthenticatedLayout>
</template>

<style scoped>
.tags h3 {
    margin-bottom: 0;
}
.taglist {
    padding: 0;
    display: flex;
    flex-wrap: wrap;
    margin: 0;
    align-items: center;
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
.last-updated {
    font-size: .7em;
    font-style: italic;
    opacity: .6;
    margin-top: 1em;
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
.titleEdit, .artistEdit, .yearEdit, .searchresults {
    width: 100%;
}

.actions {
    display: flex;
}
.actions .send {
    width: 100%;
    margin-left: .5em;
}
.actions .remove {
    width: 100%;
    margin-right: .5em;
}
.actions .remove:hover {
    background: var(--danger);
}

.lyrics {
    margin-top: 1em;
    white-space: pre-wrap;
}

.searchresults {
    padding: 0;
    margin: 0;
    list-style: none;
    background: rgba(255, 255, 255, .8);
    color: black;
    border: 1px solid var(--darkGrey);
    position: relative;
    top: -.5em;
    box-sizing: border-box;
}
.searchresults li {
    font-size: .7em;
    padding: .2em .5em;
    font-style: italic;
    cursor: pointer;
}


@media screen and (max-width: 768px) {
    .editAction .cancel {
        right: -.9em;
        top: -1.2em;
    }
}
</style>
