<script setup>
defineProps(['message']);
</script>

<template>
    <div v-show="message">
        <p class="">
            {{ message }}
        </p>
    </div>
</template>
