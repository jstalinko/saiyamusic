<template>
    <AppLayout>
        <div class="pt-32 pb-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex mb-8 text-sm font-medium text-gray-400">
                    <a href="#" class="hover:text-orange-600 transition">Product</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">{{ product.category.name ?? 'Uncategorized' }}</span>
                </nav>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 mb-24">

                    <div class="space-y-4">
                        <!-- Main image -->
                        <div class="aspect-square rounded-3xl overflow-hidden border border-gray-100 bg-white">
                            <Transition name="fade" mode="out-in">
                                <img :key="selectedImage" :src="imageUrl(selectedImage)"
                                    class="w-full h-full object-contain p-8" alt="Selected product image" />
                            </Transition>
                        </div>

                        <!-- Thumbnails -->
                        <div class="flex gap-4 overflow-x-auto pb-2">
                            <button v-for="(img, index) in product.gallery" :key="index" @click="selectedImage = img"
                                :class="[
                                    'w-24 h-24 rounded-xl border-2 overflow-hidden flex-shrink-0 transition-all',
                                    selectedImage === img
                                        ? 'border-orange-600 shadow-lg scale-95'
                                        : 'border-transparent bg-gray-50 hover:bg-gray-100'
                                ]" type="button">
                                <img :src="imageUrl(img)" class="w-full h-full object-cover" alt="Thumbnail" loading="lazy" />
                            </button>
                        </div>

                    

                    </div>


                    <div class="flex flex-col">
                        <span class="text-orange-600 font-black tracking-widest text-sm uppercase mb-2">{{
                            product.category.name ?? 'Uncategorized'
                        }} Series</span>
                        <h1 class="text-5xl font-black text-gray-900 mb-6 leading-tight">{{ product.name }}</h1>

                        <div v-html="product.description"
                            class="text-gray-600 text-lg leading-relaxed mb-10 pb-10 border-b border-gray-100">

                        </div>

                        <div class="space-y-6">
                            <h4 class="text-xl font-black flex items-center gap-2">
                                <Settings :size="20" class="text-orange-600" />
                                Technical Specifications
                            </h4>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-12">
                                <div v-for="(val, label) in product.specifications" :key="label"
                                    class="flex justify-between py-3 border-b border-gray-50">
                                    <span class="text-gray-400 font-bold text-xs uppercase tracking-wider">{{ label
                                    }}</span>
                                    <span class="text-gray-900 font-bold text-sm text-right">{{ val }}</span>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

                <div class="border-t border-gray-100 pt-20">
                    <div class="flex justify-between items-end mb-12">
                        <div>
                            <h2 class="text-3xl font-black text-gray-900">Related Instruments</h2>
                            <p class="text-gray-500 mt-2">More from the {{ product.category.name }} collection.</p>
                        </div>
                        <button
                            class="text-sm font-black text-orange-600 hover:underline uppercase tracking-widest">View
                            Collection</button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        <ProductCard v-for="item in relatedProducts" :key="item.id" :product="item" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Settings, ArrowRight, Share2 } from 'lucide-vue-next';
import ProductCard from '../Components/ProductCard.vue';
import AppLayout from '../AppLayout.vue';
import { imageUrl } from '@/helpers';
const $props = defineProps({ jdata: Object });
const product = ref($props.jdata.product);

const selectedImage = ref(product.value.image);



const relatedProducts = ref($props.jdata.relatedProducts || []);
const woodOptions = [
    {
        name: 'Ebony',
        tag: 'Fretboard',
        image: '/images/ebony.png',
        desc: 'Tight attack, smooth feel, and clear articulation—great for definition and fast playing.'
    },
    {
        name: 'Mahogany',
        tag: 'Body/Neck',
        image: '/images/meh.png',
        desc: 'Warm midrange, rich sustain, and a full-bodied tone that works across many styles.'
    },
    {
        name: 'Maple',
        tag: 'Top/Neck',
        image: '/images/mindy.png',
        desc: 'Bright response, snappy attack, and strong clarity—adds punch and presence to the sound.'
    }
];
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

/* Custom Scrollbar untuk Thumbnails */
.overflow-x-auto::-webkit-scrollbar {
    height: 4px;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    background: #e5e7eb;
    border-radius: 10px;
}
</style>