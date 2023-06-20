<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-purple-600 text-left text-base font-medium text-white bg-purple-500 focus:outline-none focus:text-white focus:bg-purple-700 focus:border-purple-700 transition duration-150 ease-in-out'
        : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-gray-400 hover:text-white hover:bg-purple-500 hover:border-purple-600 focus:outline-none focus:text-white focus:bg-purple-500 focus:border-purple-600 transition duration-150 ease-in-out'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
