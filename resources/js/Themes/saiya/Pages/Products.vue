<template>
    <AppLayout>
        <section class="py-24 bg-[#fcfcfc] min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Header -->
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-8 border-b border-gray-200 pb-6 gap-4">
                    <div>
                        <p class="text-sm text-orange-600 font-bold tracking-widest uppercase mb-2">Collections</p>
                        <h1 class="text-3xl md:text-4xl font-black text-gray-900 uppercase">
                            {{ pageTitle }}
                        </h1>
                    </div>
                    <a href="/"
                        class="px-6 py-2.5 rounded-full border-2 border-orange-600 text-orange-600 font-bold hover:bg-orange-600 hover:text-white transition-all duration-300 whitespace-nowrap">
                        &larr; Back to Home
                    </a>
                </div>

                <!-- Filters Bar -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6 mb-10">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search -->
                        <div class="md:col-span-2 relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input v-model="searchQuery" type="text" placeholder="Search products..."
                                @keyup.enter="applyFilters"
                                class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 outline-none transition-all text-gray-700 placeholder-gray-400" />
                        </div>

                        <!-- Category Select -->
                        <div class="relative">
                            <select v-model="selectedCategory" @change="onCategoryChange"
                                class="w-full py-3 px-4 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 outline-none transition-all text-gray-700 appearance-none bg-white cursor-pointer">
                                <option value="All">All Categories</option>
                                <option v-for="cat in categories" :key="cat.id" :value="cat.slug">
                                    {{ cat.name }}
                                </option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>

                        <!-- SubCategory Select -->
                        <div class="relative">
                            <select v-model="selectedSubCategory" @change="applyFilters"
                                class="w-full py-3 px-4 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 outline-none transition-all text-gray-700 appearance-none bg-white cursor-pointer">
                                <option value="">All Sub-Categories</option>
                                <option v-for="sub in filteredSubCategories" :key="sub.id" :value="sub.slug">
                                    {{ sub.name }}
                                </option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Active Filters / Search Button Row -->
                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                        <div class="flex flex-wrap gap-2">
                            <span v-if="selectedCategory !== 'All'"
                                class="inline-flex items-center gap-1 px-3 py-1 bg-orange-50 text-orange-700 rounded-full text-sm font-semibold">
                                {{ selectedCategory.replace(/-/g, ' ') }}
                                <button @click="clearCategory" class="ml-1 hover:text-orange-900">&times;</button>
                            </span>
                            <span v-if="selectedSubCategory"
                                class="inline-flex items-center gap-1 px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-sm font-semibold">
                                {{ selectedSubCategory.replace(/-/g, ' ') }}
                                <button @click="clearSubCategory" class="ml-1 hover:text-blue-900">&times;</button>
                            </span>
                            <span v-if="searchQuery"
                                class="inline-flex items-center gap-1 px-3 py-1 bg-green-50 text-green-700 rounded-full text-sm font-semibold">
                                "{{ searchQuery }}"
                                <button @click="clearSearch" class="ml-1 hover:text-green-900">&times;</button>
                            </span>
                        </div>
                        <button @click="applyFilters"
                            class="px-6 py-2 bg-orange-600 hover:bg-orange-700 text-white font-bold rounded-xl transition-all duration-300 text-sm shadow-sm hover:shadow">
                            Search
                        </button>
                    </div>
                </div>

                <!-- Product Grid -->
                <div v-if="productsList.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    <TransitionGroup name="list" enter-active-class="transition duration-500 ease-out"
                        enter-from-class="opacity-0 translate-y-8" enter-to-class="opacity-100 translate-y-0"
                        leave-active-class="absolute transition duration-300 ease-in"
                        leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
                        <ProductCard v-for="product in productsList" :key="'prod_' + product.id" :product="product" />
                    </TransitionGroup>
                </div>

                <!-- Empty State -->
                <div v-else class="text-center py-20">
                    <div class="text-gray-300 text-6xl mb-4">🎸</div>
                    <p class="text-gray-400 text-lg">Belum ada produk yang ditemukan.</p>
                    <button @click="resetFilters"
                        class="mt-6 px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold rounded-xl transition-all">
                        Reset Filters
                    </button>
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
    </AppLayout>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '../AppLayout.vue';
import ProductCard from '../Components/ProductCard.vue';

const $props = defineProps({ jdata: Object });

// Reactive state from server props
const categories = ref($props.jdata.categories);
const allSubCategories = ref($props.jdata.subCategories);
const productsList = ref([...$props.jdata.products.data]);
const nextUrl = ref($props.jdata.products.next_page_url);

// Filter state — auto-initialize from URL params
const selectedCategory = ref($props.jdata.selectedCategory || 'All');
const selectedSubCategory = ref($props.jdata.selectedSubCategory || '');
const searchQuery = ref($props.jdata.search || '');

// Computed: filter subcategories by selected category
const filteredSubCategories = computed(() => {
    if (selectedCategory.value === 'All') return allSubCategories.value;
    return allSubCategories.value.filter(sub => sub.category && sub.category.slug === selectedCategory.value);
});

// Page title
const pageTitle = computed(() => {
    let title = 'All Products';
    if (selectedCategory.value !== 'All') {
        title = selectedCategory.value.replace(/-/g, ' ');
    }
    if (selectedSubCategory.value) {
        title += ' › ' + selectedSubCategory.value.replace(/-/g, ' ');
    }
    return title;
});

// Watch for server-side product updates (pagination)
watch(() => $props.jdata.products, (newProducts) => {
    if (newProducts.current_page === 1) {
        productsList.value = [...newProducts.data];
    } else {
        productsList.value = [...productsList.value, ...newProducts.data];
    }
    nextUrl.value = newProducts.next_page_url;
}, { deep: true });

// Sync server state back to local refs on full reload
watch(() => $props.jdata.selectedCategory, (v) => { selectedCategory.value = v || 'All'; });
watch(() => $props.jdata.selectedSubCategory, (v) => { selectedSubCategory.value = v || ''; });
watch(() => $props.jdata.search, (v) => { searchQuery.value = v || ''; });

const hasMore = computed(() => !!nextUrl.value);

const applyFilters = () => {
    const params = {};
    if (selectedCategory.value !== 'All') params.category = selectedCategory.value;
    if (selectedSubCategory.value) params.subCategory = selectedSubCategory.value;
    if (searchQuery.value) params.search = searchQuery.value;
    router.get('/products', params, {
        preserveState: false,
        preserveScroll: false,
    });
};

const onCategoryChange = () => {
    // Reset subcategory when category changes
    selectedSubCategory.value = '';
    applyFilters();
};

const clearCategory = () => {
    selectedCategory.value = 'All';
    selectedSubCategory.value = '';
    applyFilters();
};

const clearSubCategory = () => {
    selectedSubCategory.value = '';
    applyFilters();
};

const clearSearch = () => {
    searchQuery.value = '';
    applyFilters();
};

const resetFilters = () => {
    selectedCategory.value = 'All';
    selectedSubCategory.value = '';
    searchQuery.value = '';
    applyFilters();
};

const loadMore = () => {
    if (nextUrl.value) {
        router.get(nextUrl.value, {}, {
            preserveState: true,
            preserveScroll: true,
            only: ['jdata']
        });
    }
};
</script>

<style scoped>
.list-move {
    transition: all 0.5s ease;
}
</style>