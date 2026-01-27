<template>
    <AppLayout>

        <!-- Article Content -->
        <article class="lg:col-span-2">
            <!-- Breadcrumb -->
            <div class="flex items-center space-x-2 text-sm text-purple-300 mb-6">
                <span class="cursor-pointer hover:text-white transition">Beranda</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="cursor-pointer hover:text-white transition">
                    <span v-if="post.labels?.length > 0">{{ parseCategory(post.labels) }}</span>
                    <span v-else> {{ ucfirst(post.type) }}</span>
                </span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-white">{{ post.title }}</span>
            </div>

            <!-- Article Header -->
            <div class="backdrop-blur-xl bg-white/10 rounded-2xl overflow-hidden border border-white/20 mb-8">
                <div class="relative">
                    <img :src="imageUrl(post.image)" :alt="post.title" class="w-full h-96 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent">
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-8">
                        <span v-if="post?.labels?.length > 0"
                            class="inline-block px-4 py-2 backdrop-blur-md bg-purple-500/80 text-white text-sm font-medium rounded-full mb-4">
                            {{ parseCategory(post.labels) }}
                        </span>
                        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">{{ post.title }}</h1>
                        <div class="flex items-center space-x-6 text-purple-200">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>{{ parseAuthorName(post.author) }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>{{ formatDate(post.created_at) }}</span>
                            </div>
                            <div class="flex items-center" v-if="post.meta?.length > 0">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd"
                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>{{ parseMetaView(post.meta) }} views</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Article Body -->
            <div class="backdrop-blur-xl bg-white/10 rounded-2xl p-8 border border-white/20 mb-8">
                <div class="prose prose-invert prose-lg max-w-none">
                    <HookRenderer place="content_single_before" />
                    <div class="text-gray-300 leading-relaxed mb-6 prose max-w-none" v-html="post.content"></div>
                    <HookRenderer place="content_single_after" />
                </div>

                <!-- Tags -->
                <div class="mt-8 pt-8 border-t border-white/20" v-if="post.labels?.length > 0">
                    <h3 class="text-white font-bold mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        Tags:
                    </h3>
                    <div class="flex flex-wrap gap-3">
                        <span v-for="tag in parseTagArray(post.labels)" :key="tag"
                            class="px-4 py-2 backdrop-blur-md bg-purple-500/30 hover:bg-purple-500/50 text-purple-200 rounded-lg cursor-pointer transition duration-300">
                            <Link :href="routeUrl('tag', tag)">
                                #{{ tag }}
                            </Link>
                        </span>
                    </div>
                </div>

                <!-- Share Buttons -->
                <div class="mt-8 pt-8 border-t border-white/20">
                    <h3 class="text-white font-bold mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                        </svg>
                        Share:
                    </h3>
                    <div class="flex space-x-4">
                        <button
                            class="px-6 py-3 backdrop-blur-md bg-blue-500/80 hover:bg-blue-600 text-white rounded-lg transition duration-300 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                            Facebook
                        </button>
                        <button
                            class="px-6 py-3 backdrop-blur-md bg-sky-500/80 hover:bg-sky-600 text-white rounded-lg transition duration-300 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                            Twitter
                        </button>
                        <button
                            class="px-6 py-3 backdrop-blur-md bg-green-500/80 hover:bg-green-600 text-white rounded-lg transition duration-300 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                            </svg>
                            WhatsApp
                        </button>
                    </div>
                </div>
            </div>

            <CommentSection :comments="comments" :post_id="post.id" :show="post.type === 'post'"
                @comment-added="addComment" />

            <!-- Related Posts -->
            <div class="backdrop-blur-xl bg-white/10 rounded-2xl p-8 border border-white/20"
                v-if="post.type === 'post'">
                <h3 class="text-2xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Artikel Terkait
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div v-for="related in relatedPosts" :key="related.id"
                        class="group cursor-pointer backdrop-blur-md bg-white/5 rounded-xl overflow-hidden border border-white/10 hover:border-purple-400/50 transition duration-300">
                        <img :src="imageUrl(related.image)" :alt="related.title"
                            class="w-full h-40 object-cover group-hover:scale-110 transition duration-500">
                        <div class="p-4">
                            <h4 class="font-bold text-white group-hover:text-purple-300 transition duration-300 mb-2">
                                {{ related.title }}</h4>
                            <p class="text-sm text-gray-400">{{ formatDate(related.created_at) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </AppLayout>


</template>

<script setup>
import AppLayout from '../AppLayout.vue';
import CommentSection from '../Components/CommentSection.vue';
import { parseCategory, parseMetaView, parseTagArray, parseAuthorName, formatDate, imageUrl, ucfirst, routeUrl, http } from '../../../helpers';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import HookRenderer from '../Components/HookRenderer.vue';
const prop = defineProps({ jdata: Object });
const post = ref(prop.jdata.post);
const comments = ref(prop.jdata.comments || []);
const relatedPosts = ref(prop.jdata.relatedPosts || []);
const addComment = (comment) => {
    comments.value.push(comment);
};
</script>

<style scoped>
/* Smooth transitions */
* {
    transition: all 0.3s ease;
}

/* Prose styling for article content */
.prose-invert p {
    color: #d1d5db;
    line-height: 1.8;
}
</style>