<script setup>
import { computed, reactive, ref, toRef, watch } from "vue";
import { Head, Link, usePage, useForm } from '@inertiajs/inertia-vue3';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import SongBigButton from '@/Components/SongBigButton.vue';
import TagFav from '@/Components/TagFav.vue';

const props = defineProps({
    tag: {
        type: Object,
    },
});

console.log(props.tag);

const form = useForm({
    name: props.tag.name,
});

let isEditing = ref(false);
let searchQuery = ref();
let searchresults = ref();


const toggleEditMode = () => {
    // if the user was editing
    // we need to go back to the inital state values (cancel modifications)
    if (isEditing) {
        form.reset();
    }

    isEditing.value = !isEditing.value;
}

const sendModifications = (tagId) => {

    form.post('/tags/' + tagId + '/edit', {
        onSuccess: (response) => {
            isEditing.value = false;
        }
    });
}

const sendDelete = (tagId) => {
    if (confirm("Voulez-vous vraiment supprimer ce classeur ?")) {
        axios.delete('/tags/' + tagId)
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
        axios.post('/songs/search', {
            search: searchterm,
        })
            .then(function (response) {
                searchresults.value = new Array();
                // Keep only the songs that are not already linked to our tag
                response.data.songs.forEach(element => {
                    if (!props.tag.songs.some((song) => {
                        // do we have any song already in this tag's songs list?
                        return element.id === song.id;
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


const chooseSong = (songId, event) => {
    axios.post('/tags/' + props.tag.id + '/songs/update', {
        song: songId,
    })
        .then(function (response) {
            // get current tag's songs from response and update local store data
            props.tag.songs = response.data.songs;
            // empty suggestions
            searchresults.value = null;
            // empty search field
            searchQuery.value = "";
        })
        .catch(function (errors) {
            console.log(errors);
        });
}
</script>

<template>
    <Head :title="'Classeur - '+tag.name" />

    <BreezeAuthenticatedLayout>
        <section class="title">
            <div v-if="isEditing" class="titleEdit-container">
                <label for="name">Classeur : </label>
                <input type="text" name="name" class="titleEdit" v-model="form.name" />
            </div>
            <h2 v-else>Classeur : {{tag.name}}</h2>
            <TagFav :tag="tag" />

            <button @click="toggleEditMode()" class="editAction">
                <img v-if="isEditing" class="cancel" src="../../img/cancel.png" alt="Annuler" width="2em" height="2em" />
                <img v-else class="edit" src="../../img/edit.png" alt="Éditer" width="2em" height="2em" />
            </button>
        </section>

        <div class="actions" v-if="isEditing">
            <button @click="sendDelete(tag.id)" class="remove">
                <span>Supprimer</span>
            </button>
            <button @click="sendModifications(tag.id)" class="send">
                <span>Enregistrer</span>
            </button>
        </div>


        <section class="songs">
            <ol class="songlist">
                <SongBigButton v-for="song in tag.songs" :key="song.id" :song="song" :isEditing="isEditing" :chooseSong="chooseSong" />
                </ol>

                <div class="modal-inner">
                <label for="tag">Ajouter une chanson à ce classeur :</label>
                <input type="text" name="tag" v-model="searchQuery" class="songAdd" @keyup="autocomplete" />
                <ul v-if="searchresults" class="searchresults">
                    <li v-for="result in searchresults" :key="result.id" @click="chooseSong(result.id, $event)">
                        <span class="songname">{{ result.title }}</span>
                    </li>
                </ul>
            </div>
        </section>

    </BreezeAuthenticatedLayout>
</template>

<style scoped>
.title, .titleEdit-container {
    display: flex;
    align-items: center;
}
.titleEdit-container, .titleEdit {
    width: 100%;
}
.editAction {
    background: none;
    width: auto;
    position: absolute;
    right: .5em;
    top: 3em;
}
.actions {
    display: flex;
    margin-bottom: 3em;
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
.actions .send {
    width: 100%;
    margin-left: .5em;
}
.actions .remove:hover {
    background: var(--danger);
}

.actions .remove {
    width: 100%;
    margin-right: .5em;
}

.modal-inner {
    width: 100%;
    margin-top: 3em;
}

.modal-inner label {
    font-size: .8em;
    font-style: italic;
    margin-right: .8em;
}

.modal-inner .songAdd {
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
    color: var(--songColor);
}

.searchresults li {
    font-size: .7em;
    padding: .5em .8em;
    font-style: italic;
    cursor: pointer;
}
.name {
    font-size: .7em;
}

@media screen and (max-width: 768px) {
    .editAction .cancel {
        right: -.9em;
        top: -1.2em;
    }
}
</style>
