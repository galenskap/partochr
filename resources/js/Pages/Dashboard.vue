<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import TagBigButton from '@/Components/TagBigButton.vue';
import SongBigButton from '@/Components/SongBigButton.vue';
import PlusButton from '@/Components/PlusButton.vue';

defineProps(['tags', 'songs']);
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
                <input type="text" class="search-form" placeholder="une chanson, un classeur..." />
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
.search-form {
    font-style: italic;
    width: 100%;
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
