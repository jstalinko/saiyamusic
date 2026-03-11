<template>
    <nav class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-lg border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex-shrink-0 flex items-center">
                   <img src="/public/logo.png"  class="w-24"  />
                </div>

                <div class="hidden md:flex space-x-8 items-center">
                    <Link v-for="item in menus" :key="item.id" :href="item.url"
                        class="text-sm font-semibold text-gray-600 hover:text-orange-600 transition">
                        {{ item.label }}
                    </Link>

                    <!-- Search Icon -->
                    <button @click="openSearch" class="text-gray-600 hover:text-orange-600 transition p-2 cursor-pointer" title="Search">
                        <Search :size="20" />
                    </button>
                    
                    <Link href="/contact"
                        class="bg-black text-white px-6 py-2.5 rounded-full text-sm font-bold hover:bg-orange-600 transition duration-300">
                        Contact Us
                    </Link>
                </div>

                <div class="md:hidden flex items-center gap-2">
                    <!-- Search Icon (Mobile) -->
                    <button @click="openSearch" class="p-2 text-gray-600 hover:text-orange-600 transition" title="Search">
                        <Search :size="24" />
                    </button>
                    <button @click="isOpen = !isOpen" class="p-2 text-gray-600">
                        <Menu v-if="!isOpen" :size="28" />
                        <X v-else :size="28" />
                    </button>
                </div>
            </div>
        </div>

        <Transition enter-active-class="transition duration-200 ease-out" enter-from-class="opacity-0 -translate-y-4"
            enter-to-class="opacity-100 translate-y-0" leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 -translate-y-4">
            <div v-if="isOpen"
                class="md:hidden bg-white border-b border-gray-100 absolute w-full px-4 pt-2 pb-6 shadow-xl">
                <div class="flex flex-col space-y-4">
                    <Link v-for="item in menus" :key="item.id" :href="item.url"
                        class="text-lg font-medium text-gray-800 py-2 border-b border-gray-50">
                        {{ item.label }}
                    </Link>
                    <Link href="/contact" class="bg-orange-600 text-white w-full py-3 rounded-xl font-bold">Contact
                        Us</Link>
                </div>
            </div>
        </Transition>
    </nav>

    <!-- Fullscreen Search Overlay -->
    <Teleport to="body">
        <Transition enter-active-class="transition duration-300 ease-out" enter-from-class="opacity-0"
            enter-to-class="opacity-100" leave-active-class="transition duration-200 ease-in"
            leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-if="isSearchOpen" class="fixed inset-0 z-[200] flex items-start justify-center bg-black/90 backdrop-blur-xl"
                @click.self="closeSearch">
                <div class="w-full max-w-3xl mx-auto mt-[20vh] px-6">
                    <!-- Close Button -->
                    <button @click="closeSearch"
                        class="absolute top-8 right-8 text-white/60 hover:text-white text-4xl transition-colors">
                        &times;
                    </button>

                    <!-- Search Label -->
                    <p class="text-white/50 text-sm font-bold tracking-widest uppercase mb-6 text-center">Search Products</p>

                    <!-- Search Input -->
                    <div class="relative">
                        <Search class="absolute left-6 top-1/2 -translate-y-1/2 text-white/40" :size="28" />
                        <input
                            ref="searchInputRef"
                            v-model="searchQuery"
                            type="text"
                            placeholder="Type to search..."
                            @keyup.enter="doSearch"
                            class="w-full bg-white/10 border border-white/20 rounded-2xl text-white text-2xl md:text-3xl font-light pl-16 pr-6 py-5 placeholder-white/30 outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/30 transition-all"
                        />
                    </div>

                    <!-- Hint -->
                    <p class="text-white/30 text-sm mt-4 text-center">Press <kbd class="px-2 py-0.5 bg-white/10 rounded text-white/50 text-xs font-mono">Enter</kbd> to search or <kbd class="px-2 py-0.5 bg-white/10 rounded text-white/50 text-xs font-mono">Esc</kbd> to close</p>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<script setup>
import { ref, nextTick, onMounted, onUnmounted } from 'vue';
import { Menu, X, Search } from 'lucide-vue-next';
import { Link, usePage, router } from '@inertiajs/vue3';

const isOpen = ref(false);
const isSearchOpen = ref(false);
const searchQuery = ref('');
const searchInputRef = ref(null);

const $page = usePage();
const [websiteName, slogan, menus] = [$page.props.setting.site_name, $page.props.setting.tagline, $page.props.setting.menus]

const openSearch = () => {
    isSearchOpen.value = true;
    nextTick(() => {
        searchInputRef.value?.focus();
    });
};

const closeSearch = () => {
    isSearchOpen.value = false;
    searchQuery.value = '';
};

const doSearch = () => {
    const query = searchQuery.value.trim();
    if (query) {
        closeSearch();
        router.get('/products', { search: query });
    }
};

// Close on Escape key
const handleKeydown = (e) => {
    if (e.key === 'Escape' && isSearchOpen.value) {
        closeSearch();
    }
};

onMounted(() => {
    document.addEventListener('keydown', handleKeydown);
});

onUnmounted(() => {
    document.removeEventListener('keydown', handleKeydown);
});
</script>