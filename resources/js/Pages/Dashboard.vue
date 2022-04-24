<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
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


        <div class="">
            <h2 class="">
                Chercher
            </h2>
        </div>


        <div class="">
            <h2 class="">
                Mes classeurs
            </h2>
        </div>
    </BreezeAuthenticatedLayout>
</template>
