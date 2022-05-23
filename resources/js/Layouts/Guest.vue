<script setup>
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>

    <div class="full-logo">
        <Link :href="route('home')">
            <img src="../../img/logo-partochr.png" alt="partochr">
        </Link>
    </div>

    <!-- Page Content -->
    <main>
        <slot />
    </main>
</template>


<style scoped>
.full-logo img {
    width: 10rem;
    height: 10rem;
    border-radius: 50%;
    margin: 5em auto 2em;
    display: block;
    text-align: center;
}
main {
    max-width: 600px;
}
</style>
