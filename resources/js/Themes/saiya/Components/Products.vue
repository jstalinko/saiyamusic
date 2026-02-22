<template>
    <section class="py-24 bg-[#fcfcfc]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-16">
                <h2 class="text-4xl font-black text-gray-900 mb-10">Our Collections</h2>

                <div class="flex flex-wrap justify-center gap-6 md:gap-12">
                    <button @click="selectCategory('All')" class="group flex flex-col items-center gap-3 transition">
                        <div
                            :class="['w-20 h-20 md:w-24 md:h-24 rounded-full flex items-center justify-center border-4 transition-all duration-300 overflow-hidden',
                                selectedCategory === 'All' ? 'border-orange-600 scale-110 shadow-lg' : 'border-transparent bg-gray-200']">
                            <span class="font-bold text-sm">ALL</span>
                        </div>
                        <span
                            :class="['font-bold text-sm tracking-widest', selectedCategory === 'All' ? 'text-orange-600' : 'text-gray-400']">SHOW
                            ALL</span>
                    </button>

                    <button v-for="cat in categories" :key="cat.name" @click="selectCategory(cat.slug)"
                        class="group flex flex-col items-center gap-3 transition">
                        <div
                            :class="['w-20 h-20 md:w-24 md:h-24 rounded-full border-4 transition-all duration-300 overflow-hidden relative',
                                selectedCategory === cat.slug ? 'border-orange-600 scale-110 shadow-lg' : 'border-transparent']">
                            <img :src="imageUrl(cat.image)"
                                class="w-full h-full object-cover group-hover:scale-120 transition-transform" />
                            <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors">
                            </div>
                        </div>
                        <span
                            :class="['font-bold text-sm tracking-widest uppercase', selectedCategory === cat.slug ? 'text-orange-600' : 'text-gray-400']">
                            {{ cat.name }}
                        </span>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <TransitionGroup name="list" enter-active-class="transition duration-500 ease-out"
                    enter-from-class="opacity-0 translate-y-8" enter-to-class="opacity-100 translate-y-0"
                    leave-active-class="absolute transition duration-300 ease-in"
                    leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
                    <ProductCard v-for="product in productsList" :key="product.id" :product="product" />
                </TransitionGroup>
            </div>

            <div v-if="productsList.length === 0" class="text-center py-20 text-gray-400">
                Produk belum tersedia untuk kategori ini.
            </div>

            <div v-if="hasMore" class="text-center mt-12">
                <button @click="loadMore"
                    class="px-8 py-3 bg-orange-600 hover:bg-orange-700 text-white font-bold rounded-full transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
                    Load More
                </button>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import ProductCard from './ProductCard.vue';
import { imageUrl } from '@/helpers';

const $prop = defineProps({
    categories: Object,
    products: Object,
    selectedCategory: {
        type: String,
        default: 'All'
    }
});

const selectedCategory = ref($prop.selectedCategory);
const categories = ref($prop.categories);

const productsList = ref([...$prop.products.data]);
const nextUrl = ref($prop.products.next_page_url);

watch(() => $prop.products, (newProducts) => {
    if (newProducts.current_page === 1) {
        productsList.value = [...newProducts.data];
    } else {
        productsList.value = [...productsList.value, ...newProducts.data];
    }
    nextUrl.value = newProducts.next_page_url;
}, { deep: true });

const hasMore = computed(() => !!nextUrl.value);

const loadMore = () => {
    if (nextUrl.value) {
        router.get(nextUrl.value, {}, {
            preserveState: true,
            preserveScroll: true,
            only: ['jdata']
        });
    }
};

const selectCategory = (categorySlug) => {
    selectedCategory.value = categorySlug;
    router.get(window.location.pathname, { category: categorySlug }, {
        preserveState: true,
        preserveScroll: true,
        only: ['jdata']
    });
};
</script>

<style scoped>
.list-move {
    transition: all 0.5s ease;
}
</style>