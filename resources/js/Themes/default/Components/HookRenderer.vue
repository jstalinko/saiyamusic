<script setup>
const props = defineProps({
    place: String,
})

import { usePage } from '@inertiajs/vue3'

const page = usePage()

// Isi HTML yang dikirim dari server
const html = page.props.hooks?.[props.place] ?? ''
</script>

<template>
    <div v-html="html"></div>
</template>
