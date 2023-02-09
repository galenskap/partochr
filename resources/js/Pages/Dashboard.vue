<script setup>
import { computed, reactive, ref } from "vue";
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import TagBigButton from '@/Components/TagBigButton.vue';
import SongBigButton from '@/Components/SongBigButton.vue';
import PlusButton from '@/Components/PlusButton.vue';

defineProps(['tags', 'songs']);

let searchresults = ref();

const autocomplete = (event) => {
    let searchterm = event.target.value;

    if (searchterm.length > 2) {
        axios.post('/search', {
            search: searchterm,
        })
        .then(function (response) {

                searchresults.value = [];

                // SONGS
                if (response.data.songs.length > 0) {
                    response.data.songs.forEach(element => {
                        searchresults.value.push({
                            "id": element.id,
                            "display": element.title,
                            "class": "songs",
                        });
                    });
                }

                // TAGS
                if (response.data.tags.length > 0) {
                    response.data.tags.forEach(element => {
                        searchresults.value.push({
                            "id": element.id,
                            "display": element.name,
                            "class": "tags",
                        });
                    });
                }

                // ARTISTS
                if (response.data.artists.length > 0) {
                    response.data.artists.forEach(element => {
                        searchresults.value.push({
                            "id": element.id,
                            "display": element.name,
                            "class": "artists",
                        });
                    });
                }

            })
            .catch(function (errors) {
                toast(errors.message, 'danger');
            });
    } else {
        // empty suggestions
        searchresults.value = null;
    }
}

const goTo = (type, id) => {
    // construct URL
    const target = '/' + type + '/' + id;
    // redirect
    window.location = target;
}
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <div class="salutations">
            <p class="hug">Bonjour {{ $page.props.auth.user.name }} !</p>
            <ul class="auth-links">
                <li>
                    <Link :href="route('logout')" method="post" as="button" class="">
                        Me déconnecter
                    </Link>
                </li>
            </ul>
        </div>

        <section class="access">
            <h2 class="">
                Consulter
            </h2>
            <ul class="access-links">
                <li>
                    <Link href="/tags" as="button" class="btn-tag">
                        <img src="../../img/folder.svg" alt="" />
                        <span>Tous les classeurs</span>
                    </Link>
                </li>
                <li>
                    <Link href="/songs" as="button" class="btn-song">
                        <img src="../../img/song.svg" alt="" />
                        <span>Toutes les chansons</span>
                    </Link>
                </li>
                <li>
                    <Link href="/artists" as="button" class="btn-artist">
                        <img src="../../img/human.svg" alt="" />
                        <span>Tous les artistes</span>
                    </Link>
                </li>
            </ul>

            <p class="search">
                <span class="label">ou chercher :</span>
                <input type="text" name="searchform" class="global-search" @keyup="autocomplete" placeholder="une chanson, un classeur..." />
                <ul v-if="searchresults" class="searchresults">
                    <li v-for="result in searchresults" :key="result.id" @click="goTo(result.class, result.id)" :class="result.class">
                        <img v-if="result.class == 'tags'" src="../../img/folder.svg" alt="Classeur : " />
                        <img v-if="result.class == 'songs'" src="../../img/song.svg" alt="Chanson : " />
                        <img v-if="result.class == 'artists'" src="../../img/human.svg" alt="Artiste : " />
                        <span>{{ result.display }}</span>
                    </li>
                </ul>
            </p>
        </section>


        <section class="my-tags">
            <h2 class="">
                Classeurs favoris
            </h2>
            <ul class="taglist">
                <PlusButton model="tags" />
                <TagBigButton :id="tag.id" :tag="tag" :displayFav="false" v-for="tag in tags" :key="tag.id" />
            </ul>
        </section>

        <section class="my-songs">
            <h2 class="">
                Dernières chansons modifiées
            </h2>
            <ul class="songlist">
                <PlusButton model="songs" />
                <SongBigButton v-for="song in songs" :key="song.id" :song="song" />
            </ul>
            <Link :href="route('song-recents')" class="last-updated link">Voir les chansons par date de modification</Link>
        </section>
    </BreezeAuthenticatedLayout>
</template>

<style scoped>
.hug {
    font-style: italic;
    margin: 2em 0 .2em;
}
.auth-links, .access-links {
    list-style: none;
    padding: 0;
    margin: 0;
    font-size: .8em;
}
.auth-links button,
.access-links button {
    margin: 0 .3em .3em 0;
}
.access-links li {
    flex: 1 1 100%;
    display: flex;
}
@media screen and (min-width: 768px) {
    .auth-links, .access-links {
        display: flex;
    }
}
section {
    margin-bottom: 2em;
    display: flex;
    flex-direction: column;
}
.access {
    margin-top: 2em;
}
.global-search {
    font-style: italic;
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
}
.searchresults li {
    font-size: .8em;
    padding: .5em .8em;
    font-style: italic;
    cursor: pointer;
    display: flex;
    align-items: center;
}
.searchresults li img {
    width: 1.5em;
    margin-right: .7em;
}
.searchresults .songs {
    color: var(--songColor);
}
.searchresults .songs img {
    filter: invert(50%) sepia(100%) saturate(220%) hue-rotate(148deg);
}
.searchresults .tags {
    color: var(--tagColor);
}
.searchresults .tags img {
    filter: invert(40%) sepia(100%) saturate(400%) hue-rotate(328deg);
}
.searchresults .artists {
    color: var(--darkGrey);
}
.searchresults .artists img {
    filter: invert(20%) sepia(0%) saturate(0%) hue-rotate(0deg) opacity(60%);
}

.taglist, .songlist {
    list-style: none;
    padding: 0;
    display: flex;
    flex-direction: column;
}
.taglist li, .songlist li {
    display: flex;
    flex-direction: row;
    margin-bottom: .5em;
}

.access-links button {
    padding: 1em;
    position: relative;
    overflow: hidden;
    font-weight: bold;
}
.access-links button:hover {
    opacity: .8;
}
.access-links button img {
    position: absolute;
    mix-blend-mode: overlay;
}
.btn-tag {
    background-color: var(--tagColor);
}
.btn-song {
    background-color: var(--songColor);
}
.access-links .btn-tag img {
    filter: invert(100%);
    width: 5.5em;
    top: -.8em;
    left: -1em;
    mix-blend-mode: soft-light;
}
.access-links .btn-song img {
    filter: invert(57%) sepia(100%) saturate(220%) hue-rotate(172deg);
    width: 5.5em;
    top: -1.6em;
    left: -1.4em;
}
.access-links .btn-artist img {
    filter: invert(100%) sepia(0%) saturate(0%) hue-rotate(0deg) opacity(60%);
    width: 5.2em;
    top: -.8em;
    left: -1em;
}
.access-links .btn-artist:hover {
    background-color: var(--darkGrey);
}
.last-updated {
    text-align: center;
    font-size: .8em;
    text-decoration: none;
}
</style>
