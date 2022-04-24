<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/inertia-vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <header class="page-header">
        <div class="content">
            <!-- Logo -->
            <div class="logo">
                <Link :href="route('home')">
                    <ApplicationLogo class="" />
                </Link>
            </div>
        </div>

        <div class="settings">
            <span class="fontsize less">A-</span>
            <span class="fontsize more">A+</span>
            <span class="switchTheme">Dark mode</span>

            <span class="whoami">
                {{ $page.props.auth.user.name }}
            </span>
        </div>
    </header>

    <!-- Page Heading -->
    <header class="content-header" v-if="$slots.header">
        <div class="">
            <slot name="header" />
        </div>
    </header>

    <!-- Page Content -->
    <main>
        <slot />
    </main>
</template>


<style>

</style>
