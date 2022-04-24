<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>

    <div class="full-logo">
        <Link :href="route('home')">
            <img src="">
        </Link>
    </div>

    <!-- Page Content -->
    <main>
        <slot />
    </main>
</template>


<style scoped>

</style>
