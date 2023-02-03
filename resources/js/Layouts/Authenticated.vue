<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/inertia-vue3';

const showingNavigationDropdown = ref(false);
const fsize = ref(1);
const theme = ref('theme-dark');

const switchTheme = () => {
    // change body class...
    document.body.classList.toggle('theme-dark');
    document.body.classList.toggle('theme-light');
};
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
            <span class="fontsize less" @click="fsize -= 0.2">A-</span>
            <span class="fontsize more" @click="fsize += 0.2">A+</span>
            <img class="switchTheme" src="../../img/light.svg" alt="change mode" @click="switchTheme">
        </div>
    </header>

    <!-- Page Heading -->
    <header class="content-header" v-if="$slots.header">
        <div class="">
            <slot name="header" />
        </div>
    </header>

    <!-- Page Content -->
    <main :style="{ fontSize: fsize + 'em' }" :class="theme">
        <slot />
    </main>
</template>


<style scoped>
.logo a {
    text-decoration: none;
    font-weight: bold;
}
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: .5em;
    background: var(--darkGrey);
    font-size: .8em;
}
.settings {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    color: var(--white);
}
.fontsize.less {
    font-size: .8em;
}
.fontsize.more {
    margin-left: .3em;
    font-size: 1em;
}
.switchTheme {
    margin-left: 1em;
    font-size: .7em;
    width: 1.8em;
    filter: invert(100%);
}
.fontsize, .switchTheme {
    cursor: pointer;
}
.fontsize:hover {
    color: var(--songColor);
}
.switchTheme:hover {
    filter: invert(70%) sepia(200%) saturate(220%) hue-rotate(140deg); /* kindof blue */
}
</style>
