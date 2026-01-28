<template>
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between items-end mb-12">
                <div class="max-w-2xl">
                    <h2 class="text-orange-600 font-black tracking-[0.2em] uppercase text-sm mb-3">Journal</h2>
                    <h3 class="text-4xl md:text-5xl font-black text-gray-900 leading-tight">
                        Latest News & <br /><span class="text-gray-400 font-light italic">Factory Updates</span>
                    </h3>
                </div>
                <a href="#"
                    class="hidden md:flex items-center gap-2 font-bold text-gray-900 hover:text-orange-600 transition group mt-6 md:mt-0">
                    All News
                    <ArrowUpRight :size="20"
                        class="group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform" />
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div
                    class="lg:col-span-2 group cursor-pointer overflow-hidden rounded-3xl bg-white shadow-sm border border-gray-100">
                    <div class="relative overflow-hidden aspect-[16/9]">
                        <img :src="imageUrl(newsList[0].image)"
                            class="w-full h-full object-cover transition duration-700 group-hover:scale-105" />
                        <div class="absolute top-6 left-6">
                            <span
                                class="bg-white/90 backdrop-blur-md px-4 py-2 rounded-full text-xs font-black uppercase tracking-widest text-gray-900 shadow-sm">
                                {{ formatDate(newsList[0].created_at) }}
                            </span>
                        </div>
                    </div>

                    <div class="p-8">
                        <span class="text-orange-600 font-bold text-xs uppercase tracking-widest">{{
                            newsList[0].category }} </span>
                        <h4
                            class="text-3xl font-black text-gray-900 mt-3 mb-4 group-hover:text-orange-600 transition-colors leading-tight">
                            {{ newsList[0].title }}
                        </h4>
                        <p class="text-gray-600 leading-relaxed line-clamp-2">
                            {{ stripTags(newsList[0].excerpt) }}
                        </p>
                    </div>
                </div>

                <div class="flex flex-col gap-8">
                    <div v-for="(news, index) in newsList.slice(1)" :key="index"
                        class="group cursor-pointer flex gap-5">
                        <div class="w-32 h-32 flex-shrink-0 overflow-hidden rounded-2xl bg-gray-200">
                            <img :src="imageUrl(news.image)"
                                class="w-full h-full object-cover transition duration-500 group-hover:scale-110" />
                        </div>
                        <div class="flex flex-col justify-center">
                            <span class="text-[10px] font-black text-orange-600 uppercase tracking-widest mb-1">{{
                                news.category }}</span>
                            <h5
                                class="text-lg font-bold text-gray-900 leading-snug group-hover:text-orange-600 transition-colors">
                                {{ news.title }}
                            </h5>
                            <p class="text-xs text-gray-400 mt-2 font-medium">{{ formatDate(news.created_at) }}</p>
                        </div>
                    </div>

                    <a href="#"
                        class="md:hidden flex items-center justify-center gap-2 p-4 border border-gray-200 rounded-xl font-bold">
                        View All News
                        <ArrowRight :size="18" />
                    </a>
                </div>

            </div>
        </div>
    </section>
</template>

<script setup>
import { ArrowUpRight, ArrowRight } from 'lucide-vue-next';
import { imageUrl, formatDate, stripTags } from '@/helpers';

const $prop = defineProps({ posts: Object });
const newsList = $prop.posts;
</script>

<style scoped>
/* Menghaluskan pemotongan teks jika deskripsi terlalu panjang */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>