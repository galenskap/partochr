<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import TagBigButton from '@/Components/TagBigButton.vue';

// TODO: put this in a store
const myTags = [
    {
        id: 1,
        name: 'Country',
        nbSongs: 12,
    },
    {
        id: 2,
        name: 'Classiques Jean',
        nbSongs: 139,
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <div class="salutations">
            <p class="hug">Bonjour {{ $page.props.auth.user.name }} !</p>
            <ul class="auth-links">
                <li>
                    <Link :href="route('logout')" method="post" class="">
                        Me déconnecter
                    </Link>
                </li>
            </ul>
        </div>


        <section class="search">
            <h2 class="">
                Chercher
            </h2>
            <input type="text" class="search-form" placeholder="une chanson, un classeur..." />
        </section>


        <section class="my-tags">
            <h2 class="">
                Mes classeurs
            </h2>
            <div class="tags">
                <TagBigButton v-for="tag in myTags" :key="tag.id" :name="tag.name" :nbSongs="tag.nbSongs" />
            </div>
        </section>
    </BreezeAuthenticatedLayout>
</template>

<style scoped>
.hug {
    font-style: italic;
    margin: 2em 0 .2em;
}
.auth-links {
    list-style: none;
    padding: 0;
    margin: 0;
    font-size: .8em;
}
section {
    margin-bottom: 2em;
    display: flex;
    flex-direction: column;
}
.search {
    margin-top: 2em;
}
.search-form {
    font-style: italic;
}
</style>
