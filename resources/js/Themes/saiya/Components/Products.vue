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

            <!-- SubCategory Grid -->
            <div v-if="subCategoriesList.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <TransitionGroup name="list" enter-active-class="transition duration-500 ease-out"
                    enter-from-class="opacity-0 translate-y-8" enter-to-class="opacity-100 translate-y-0"
                    leave-active-class="absolute transition duration-300 ease-in"
                    leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">

                    <SubCategoryCard v-for="sub in subCategoriesList" :key="'sub_'+sub.id" :subCategory="sub"
                        @click="goToSubCategory(sub)" />
                </TransitionGroup>
            </div>

            <div v-if="subCategoriesList.length === 0" class="text-center py-20 text-gray-400">
                Kategori belum memiliki sub-koleksi.
            </div>

            <!-- Load More -->
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
import SubCategoryCard from './SubCategoryCard.vue';
import { imageUrl } from '@/helpers';

const $prop = defineProps({
    categories: Object,
    subCategories: Object,
    selectedCategory: {
        type: String,
        default: 'All'
    }
});

const selectedCategory = ref($prop.selectedCategory);
const categories = ref($prop.categories);

const subCategoriesList = ref($prop.subCategories ? [...$prop.subCategories.data] : []);
const nextUrl = ref($prop.subCategories ? $prop.subCategories.next_page_url : null);

watch(() => $prop.subCategories, (newSubCategories) => {
    if (newSubCategories) {
        if (newSubCategories.current_page === 1) {
            subCategoriesList.value = [...newSubCategories.data];
        } else {
            subCategoriesList.value = [...subCategoriesList.value, ...newSubCategories.data];
        }
        nextUrl.value = newSubCategories.next_page_url;
    } else {
        subCategoriesList.value = [];
    }
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

const goToSubCategory = (sub) => {
    const catSlug = selectedCategory.value !== 'All' ? selectedCategory.value : (sub.category ? sub.category.slug : 'All');
    router.get('/products', { category: catSlug, subCategory: sub.slug });
};
</script>

<style scoped>
.list-move {
    transition: all 0.5s ease;
}

.fade-slide-enter-active,
.fade-slide-leave-active {
    transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
}

.fade-slide-enter-from,
.fade-slide-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}
</style>