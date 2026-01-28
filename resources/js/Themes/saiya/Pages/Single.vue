<template>
    <AppLayout>
        <article class="pt-32 pb-24 bg-white">
            <header class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-16">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-50 text-orange-600 text-xs font-black uppercase tracking-widest mb-6">
                    <Calendar :size="14" />
                    <span>{{ formatDate(post.created_at) }}</span>
                    <span class="mx-2 text-orange-200">|</span>
                    <span>{{ parseCategory(post.labels) }}</span>
                </div>

                <h1 class="text-4xl md:text-6xl font-black text-gray-900 leading-[1.1] mb-8">
                    {{ post.title }}
                </h1>


            </header>

            <div class="max-w-6xl mx-auto px-4 mb-16">
                <div class="aspect-[21/9] rounded-[2rem] overflow-hidden shadow-2xl">
                    <img :src="imageUrl(post.image)" class="w-full h-full object-cover" alt="New Factory Facility" />
                </div>
            </div>

            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="prose prose-lg prose-orange max-w-none text-gray-600 leading-relaxed">
                    <div v-html="post.content"></div>
                </div>

                <div
                    class="mt-16 pt-8 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="flex gap-2">
                        <span v-for="label in parseTagArray(post.labels)" :key="label.id"
                            class="px-4 py-2 bg-gray-100 rounded-lg text-xs font-bold text-gray-600">{{ label }}</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-sm font-bold text-gray-400">Share:</span>
                        <button class="text-gray-400 hover:text-orange-600 transition">
                            <Facebook :size="20" />
                        </button>
                        <button class="text-gray-400 hover:text-orange-600 transition">
                            <Twitter :size="20" />
                        </button>
                        <button class="text-gray-400 hover:text-orange-600 transition">
                            <LinkIcon :size="20" />
                        </button>
                    </div>
                </div>
            </div>
        </article>
    </AppLayout>
</template>

<script setup>
import AppLayout from '../AppLayout.vue'
import { parseCategory, formatDate, parseTagArray } from '@/helpers';
import { Calendar, Facebook, Twitter, Link as LinkIcon } from 'lucide-vue-next'
import { imageUrl } from '../../../helpers';
const $props = defineProps({ jdata: Object });
const post = $props.jdata.post;
</script>

<style scoped>
/* Styling tambahan untuk elemen prose jika tidak menggunakan @tailwindcss/typography */
.prose h3 {
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.prose p {
    margin-bottom: 1.5rem;
}
</style>