<template>
    <nav v-if="paginator!==undefined" aria-label="{{ __('Pagination Navigation') }}" class="paginator-container" role="navigation">
        <div class="paginator-inner">
            <span v-if="onFirstPage()" aria-disabled="true" class="disabled link">
                <span aria-hidden="true" class="">
                    <svg class="arrows" fill="currentColor" viewBox="0 0 20 20">
                        <path clip-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                fill-rule="evenodd"/>
                    </svg>
                </span>
            </span>
            <inertia-link v-else :href="paginator.prev_page_url" class="" rel="prev">
                <svg class="arrows" fill="currentColor" viewBox="0 0 20 20">
                    <path clip-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            fill-rule="evenodd"/>
                </svg>
            </inertia-link>

            <div v-for="link in paginator.links" class="link">
                <inertia-link v-if="!isFirstOrLastOrDots(link.label)" 
                                :class="(link.active===true)? 'disabled' : ''"
                                :aria-disabled="(link.active===true)? 'true' : 'false'"
                                :href="link.url">
                    {{ link.label }}
                </inertia-link>
                <span v-else-if="link.label==='...'" aria-disabled="true">
                    <span class="">
                        {{ link.label }}
                    </span>
                </span>
            </div>

            <inertia-link v-if="hasMorePages()" :href="paginator.next_page_url" class="link">
                <svg class="arrows" fill="currentColor" viewBox="0 0 20 20">
                    <path clip-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            fill-rule="evenodd"/>
                </svg>
            </inertia-link>
            <span v-else aria-disabled="true" class="link disabled">
                <span aria-hidden="true" class="">
                    <svg class="arrows" fill="currentColor" viewBox="0 0 20 20">
                        <path clip-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                fill-rule="evenodd"/>
                    </svg>
                </span>
            </span>
        </div>
    </nav>

</template>

<script setup>
import { Head, Link, InertiaLink } from '@inertiajs/inertia-vue3';

const props = defineProps({
    paginator: {
        current_page: Number,
        data: Array,
        first_page_url: String,
        from: Number,
        last_page: Number,
        last_page_url: String,
        links: Array,
        next_page_url: String,
        path: String,
        per_page: Number,
        prev_page_url: String,
        to: Number,
        total: Number,
    }
});

const isFirstOrLastOrDots = (label) => {
    return label.includes('Next') || label.includes('Previous') || label.includes('...')
};

const onFirstPage = () => {
    return props.paginator.current_page === 1;
};

const hasMorePages = () => {
    return props.paginator.current_page < props.paginator.last_page;
};

const firstItem = () => {
    return props.paginator.from;
};

const lastItem = () => {
    return props.paginator.to;
};

const total = () => {
    return props.paginator.total;
};
</script>

<style scoped>
.disabled {
    pointer-events: none;
    cursor: initial;
    text-decoration: none;
    color: var(--darkGrey);
}
.arrows {
    width: 1em;
}
.link {
    padding: 0 .5em;
}
.paginator-inner {
    display: flex;
    justify-content: center;
}
</style>
