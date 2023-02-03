<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import TagBigButton from '@/Components/TagBigButton.vue';

defineProps(['tags']);
</script>

<template>
    <Head title="Tous les classeurs" />

    <BreezeAuthenticatedLayout>
        <section class="title">
            <h2>Tous les classeurs</h2>
        </section>

        <section class="tags">
            <ul class="taglist">
                <TagBigButton :tag="tag" :displayFav="true" v-for="tag in tags" :key="tag.id" />
            </ul>
        </section>

    </BreezeAuthenticatedLayout>
</template>

<style scoped>
.taglist {
    list-style: none;
    padding: 0;
    display: flex;
    flex-direction: column;
}
</style>
