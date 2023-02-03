<script setup>
import { computed, reactive, ref } from "vue";
import { Head, Link, usePage, useForm } from '@inertiajs/inertia-vue3';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import SongSmallButton from '@/Components/SongSmallButton.vue';

const props = defineProps({
    artist: {
        type: Object,
    }
});

const form = useForm({
    name: props.artist.name,
});

let isEditing = ref(false);

const toggleEditMode = () => {
    // if the user was editing
    // we need to go back to the inital state values (cancel modifications)
    if (isEditing) {
        form.reset();
    }

    isEditing.value = !isEditing.value;
}

const sendModifications = (artistId) => {

    form.post('/artists/' + artistId + '/edit', {
        onSuccess: (response) => {
            isEditing.value = false;
        }
    });
}

const sendDelete = (artistId) => {
    if (confirm("Voulez-vous vraiment supprimer cet artiste ?")) {
        axios.delete('/artists/' + artistId)
            .then((response) => {
                isEditing.value = false;
                toast(response.data.message, 'success');
                window.location = route('home'); // redirect to home
            });
    }
}
</script>

<template>
    <Head :title="'Artiste - '+artist.name" />

    <BreezeAuthenticatedLayout>
        <section class="title">
            <div v-if="isEditing" class="titleEdit-container">
                <label for="name">Artiste : </label>
                <input type="text" name="name" class="titleEdit" v-model="form.name" />
            </div>
            <h2 v-else>Artiste : {{artist.name}}</h2>

            <button @click="toggleEditMode()" class="editAction">
                <img v-if="isEditing" class="cancel" src="../../img/cancel.png" alt="Annuler" width="2em" height="2em" />
                <img v-else class="edit" src="../../img/edit.png" alt="Éditer" width="2em" height="2em" />
            </button>
        </section>

        <div class="actions" v-if="isEditing">
            <button @click="sendModifications(artist.id)" class="send">
                <span>Enregistrer</span>
            </button>
            <button @click="sendDelete(artist.id)" class="remove">
                <span>Supprimer</span>
            </button>
        </div>


        <section class="songs">
            <ul class="songlist">
                <li v-for="song in artist.songs" :key="song.id">
                    <SongSmallButton :id="song.id" :song="song"/>
                </li>
            </ul>
            <!-- bouton "+" (ajout chanson existante [search] ou nouvelle [form]) -->
        </section>

    </BreezeAuthenticatedLayout>
</template>

<style scoped>
.songlist {
    list-style: none;
    padding: 0;
}
.title,
.titleEdit-container {
    display: flex;
    align-items: center;
}

.titleEdit-container,
.titleEdit {
    width: 100%;
}

.actions {
    display: flex;
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
.actions .send {
    width: 100%;
    margin-right: .5em;
}
.actions .remove {
    width: 100%;
    margin-left: .5em;
}
.actions .remove:hover {
    background: var(--danger);
}

.song-small-button {
    margin-right: 0;
}

@media screen and (max-width: 768px) {
    .editAction .cancel {
        right: -.9em;
        top: -1.2em;
    }
}
</style>
