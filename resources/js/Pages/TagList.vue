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
                <li v-for="tag in tags" :key="tag.id">
                    <TagBigButton :id="tag.id" :tag="tag" />
                </li>
            </ul>
        </section>

    </BreezeAuthenticatedLayout>
</template>

<style scoped>
.taglist {
    list-style: none;
    padding: 0;
}
</style>
