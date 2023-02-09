<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import TagBigButton from '@/Components/TagBigButton.vue';
import Paginator from "@/Components/Paginator";

const props = defineProps({
    tags: {
        type: Object,
    },
});
</script>

<template>
    <Head title="Tous les classeurs" />

    <BreezeAuthenticatedLayout>
        <section class="title">
            <h2>Tous les classeurs</h2>
        </section>

        <section class="tags">
            <ul class="taglist">
                <TagBigButton :tag="tag" :displayFav="true" v-for="tag in tags.data" :key="tag.id" />
            </ul>
        </section>

        <Paginator :paginator="tags" />
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
