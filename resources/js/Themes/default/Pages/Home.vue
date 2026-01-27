<template>
    <AppLayout>
        <Article :articles="articles" :perPage="3" />
    </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { usePage } from '@inertiajs/vue3';
import AppLayout from '../AppLayout.vue';
import Article from '../Components/Article.vue';
const prop = defineProps({ jdata: Object });
const articles = ref(prop.jdata.posts)
console.log(usePage().props.hooks);

</script>

<style scoped>
* {
    transition: all 0.3s ease;
}
</style>
