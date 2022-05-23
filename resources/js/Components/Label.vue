<script setup>
defineProps(['value']);
</script>

<template>
    <label class="">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
