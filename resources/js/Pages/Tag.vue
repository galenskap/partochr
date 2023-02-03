<script setup>
import { computed, reactive, ref } from "vue";
import { Head, Link, usePage, useForm } from '@inertiajs/inertia-vue3';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import SongBigButton from '@/Components/SongBigButton.vue';
import TagFav from '@/Components/TagFav.vue';

const props = defineProps({
    tag: {
        type: Object,
    },
    songs: {
        type: Array,
    }
});

const form = useForm({
    name: props.tag.name,
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
            <button @click="sendModifications(tag.id)" class="send">
                <span>Enregistrer</span>
            </button>
            <button @click="sendDelete(tag.id)" class="remove">
                <span>Supprimer</span>
            </button>
        </div>


        <section class="songs">
            <ol class="songlist">
                <SongBigButton v-for="song in songs" :key="song.id" :song="song" />
            </ol>
            <!-- bouton "+" (ajout chanson existante [search] ou nouvelle [form]) -->
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
.actions .remove:hover {
    background: var(--danger);
}

.actions .remove {
    width: 100%;
    margin-left: .5em;
}

@media screen and (max-width: 768px) {
    .editAction .cancel {
        right: -.9em;
        top: -1.2em;
    }
}
</style>
