<template>
    <!-- Header -->
    <header class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-600/30 to-pink-600/30 backdrop-blur-xl"></div>
        <div class="relative container mx-auto px-4 py-12 text-center">
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-3 tracking-tight">
                {{ websiteName }}
            </h1>
            <p class="text-xl text-purple-200 font-light">{{ slogan }}</p>
        </div>
    </header>

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 backdrop-blur-md bg-white/10 border-b border-white/20">
        <div class="container mx-auto px-4">
            <ul class="flex space-x-8 py-4 overflow-x-auto">

                <!-- LOOP SEMUA MENU -->
                <template v-for="menu in menus" :key="menu.id">

                    <!-- Jika menu parent -->
                    <li v-if="menu.is_parent" class="relative group whitespace-nowrap">

                        <!-- Parent button -->
                        <div
                            class="cursor-pointer text-white hover:text-purple-300 transition duration-300 font-medium flex items-center">
                            {{ menu.label }}

                            <!-- Icon dropdown -->
                            <svg class="w-4 h-4 ml-1 transition-transform duration-300 group-hover:rotate-180"
                                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                        <!-- Dropdown anak -->
                        <ul
                            class="absolute left-0 mt-2 w-48 bg-white/20 backdrop-blur-xl rounded-lg shadow-lg border border-white/20
                               opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-1">

                            <li v-for="child in menus.filter(c => c.parent_id === menu.id)" :key="child.id">
                                <div @click="router.visit(child.url)"
                                    class="px-4 py-2 text-white hover:bg-white/30 hover:text-purple-200 transition cursor-pointer ">
                                    {{ child.label }}
                                </div>
                            </li>

                        </ul>
                    </li>

                    <!-- Jika menu biasa (bukan parent dan bukan child) -->
                    <li v-else-if="menu.parent_id === null"
                        class="cursor-pointer text-white hover:text-purple-300 transition duration-300 font-medium whitespace-nowrap">
                        <Link :href="menu.url">
                        {{ menu.label }}
                        </Link>
                    </li>

                    <!-- CHILD tidak ditampilkan di luar dropdown -->
                </template>

            </ul>
        </div>
    </nav>


</template>

<script setup>
import { usePage, Link, router } from '@inertiajs/vue3';
const $page = usePage();
const [websiteName, slogan, menus] = [$page.props.setting.site_name, $page.props.setting.tagline, $page.props.setting.menus]


</script>