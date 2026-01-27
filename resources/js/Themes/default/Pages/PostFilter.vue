<template>
    <AppLayout>
        <!-- buat card filter -->
        <div
            class="backdrop-blur-xl bg-white/10 rounded-2xl overflow-hidden border border-white/20 hover:border-purple-400/50 transition-all duration-500 hover:scale-[1.02] hover:shadow-2xl hover:shadow-purple-500/20 text-white p-4">
            {{ ucfirst(filterType) }} : {{ filterValue }}
        </div>
        <Article :articles="articles" :perPage="3" />
    </AppLayout>
</template>
<script setup>
import { ref } from 'vue';
import Article from '../Components/Article.vue';
import AppLayout from '../AppLayout.vue';
import { ucfirst } from '../../../helpers';
const prop = defineProps({ jdata: Object });
const articles = ref(prop.jdata.posts);
const filterType = ref(prop.jdata.filterType);
const filterValue = ref(prop.jdata.filterValue);
</script>