<template>
    <div
        class="group relative bg-white rounded-2xl p-4 transition-all duration-500 hover:shadow-2xl border border-gray-100 flex flex-col h-full cursor-pointer"
        @click="$emit('select', subCategory.slug)">
        <div class="relative aspect-[3/4] overflow-hidden rounded-xl mb-5">
            <!-- Skeleton Loader -->
            <div v-if="!imageLoaded"
                class="absolute inset-0 bg-gradient-to-r from-gray-200 via-gray-100 to-gray-200 animate-pulse">
            </div>

            <!-- Actual Image -->
            <img :src="imageUrl(subCategory.image)" :alt="subCategory.name" loading="lazy" @load="handleImageLoad" :class="[
                'w-full h-full object-contain transition-all duration-700',
                imageLoaded ? 'opacity-100 scale-100 group-hover:scale-110' : 'opacity-0 scale-95'
            ]" />

            <div class="absolute top-3 left-3">
                <span
                    class="bg-black/80 backdrop-blur-md text-white text-[10px] font-black px-3 py-1 rounded-full tracking-widest uppercase">
                    SERIES
                </span>
            </div>

            <div
                class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                <button
                    class="bg-white text-black px-6 py-2 rounded-full font-bold text-sm transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                    View Products
                </button>
            </div>
        </div>

        <div class="flex-grow">
            <div class="flex items-center gap-2 mb-2">
                <span class="h-[1px] w-5 bg-orange-600"></span>
                <span class="text-[11px] font-bold text-orange-600 uppercase tracking-[0.2em]">
                    {{ subCategory.category?.name ?? 'Category' }}
                </span>
            </div>

            <h3 class="text-xl font-black text-gray-900 leading-tight mb-4 group-hover:text-orange-600 transition-colors">
                {{ subCategory.name }}
            </h3>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { imageUrl } from '@/helpers';

defineProps(['subCategory']);
defineEmits(['select']);

const imageLoaded = ref(false);

const handleImageLoad = () => {
    imageLoaded.value = true;
};
</script>
