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
                    <Link href="/tags" as="button">Tous les classeurs</Link>
                </li>
                <li>
                    <Link href="/songs" as="button">Toutes les chansons</Link>
                </li>
                <li>
                    <Link href="/artists" as="button">Tous les artistes</Link>
                </li>
            </ul>

            <p class="search">
                <span class="label">ou chercher :</span>
                <input type="text" name="searchform" class="global-search" @keyup="autocomplete" placeholder="une chanson, un classeur..." />
                <ul v-if="searchresults" class="searchresults">
                    <li v-for="result in searchresults" :key="result.id" @click="goTo(result.class, result.id)" :class="result.class">{{ result.display }}</li>
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
                Mes dernières chansons
            </h2>
            <ul class="songlist">
                <PlusButton model="songs" />
                <!-- latest songs links -->
                <SongBigButton v-for="song in songs" :key="song.id" :song="song" />
            </ul>
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
}
.searchresults .songs {
    color: var(--songColor);
}
.searchresults .tags {
    color: var(--tagColor);
}
.searchresults .artists {
    color: var(--darkGrey);
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
</style>
