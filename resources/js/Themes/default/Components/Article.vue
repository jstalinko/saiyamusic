<template>
    <article v-for="article in paginatedArticles" :key="article.id"
        class="group relative backdrop-blur-xl bg-white/10 rounded-2xl overflow-hidden border border-white/20 hover:border-purple-400/50 transition-all duration-500 hover:scale-[1.02] hover:shadow-2xl hover:shadow-purple-500/20">
        <div class="relative overflow-hidden">
            <img :src="imageUrl(article.image)" :alt="article.title"
                class="w-full h-72 object-cover transform group-hover:scale-110 transition duration-700" />
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            <div class="absolute top-4 left-4">
                <span class="px-4 py-1 backdrop-blur-md bg-purple-500/80 text-white text-sm font-medium rounded-full">
                    {{ parseCategory(article.labels) }}
                </span>
            </div>
        </div>
        <div class="p-8">
            <div class="flex items-center text-sm text-purple-300 mb-4">
                <svg class="w-4 h-4 mr-2" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                        clip-rule="evenodd" />
                </svg>
                <span>{{ dateFormatHuman(article.created_at) }}</span>
            </div>

            <h2 class="text-3xl font-bold mb-4 text-white group-hover:text-purple-300 transition duration-300">
                <Link :href="routeUrl('post', article.slug)">{{ article.title }}</Link>
            </h2>

            <p class="text-gray-300 mb-6 leading-relaxed">
                {{ excerpt(article.excerpt) }}
            </p>

            <Link :href="routeUrl('post', article.slug)"
                class="px-6 py-3 backdrop-blur-md bg-purple-500/80 hover:bg-purple-600 text-white font-medium rounded-xl transition duration-300 flex items-center max-w-fit">

                Baca Selengkapnya
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </Link>
        </div>
    </article>
    <div class="flex justify-center items-center space-x-2 mt-8">
        <button @click="prevPage" :disabled="currentPage === 1"
            class="px-4 py-2 backdrop-blur-md bg-white/10 border border-white/20 text-white rounded-lg hover:bg-white/20 disabled:opacity-50 disabled:cursor-not-allowed transition duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        <button v-for="page in totalPages" :key="page" @click="currentPage = page" :class="[
            'px-4 py-2 backdrop-blur-md rounded-lg transition duration-300',
            currentPage === page
                ? 'bg-purple-500 text-white'
                : 'bg-white/10 border border-white/20 text-white hover:bg-white/20'
        ]">
            {{ page }}
        </button>

        <button @click="nextPage" :disabled="currentPage === totalPages"
            class="px-4 py-2 backdrop-blur-md bg-white/10 border border-white/20 text-white rounded-lg hover:bg-white/20 disabled:opacity-50 disabled:cursor-not-allowed transition duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>
</template>
<script setup>
import { dateFormatHuman, excerpt, imageUrl, parseCategory, routeUrl } from '../../../helpers';
import { Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
const prop = defineProps({ articles: Object, perPage: Number });
const currentPage = ref(1);
const totalPages = computed(() => Math.ceil(prop.articles.length / prop.perPage))
const paginatedArticles = computed(() => {
    const start = (currentPage.value - 1) * prop.perPage
    return prop.articles.slice(start, start + prop.perPage)
})
const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++
        window.scrollTo({ top: 0, behavior: 'smooth' })
    }
}
const prevPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--
        window.scrollTo({ top: 0, behavior: 'smooth' })
    }
}
</script>