<template>
    <nav class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-lg border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <span class="text-xl font-bold tracking-tighter text-gray-900">
                        PT SAIYA <span class="text-orange-600">INDONESIA</span>
                    </span>
                </div>

                <div class="hidden md:flex space-x-8 items-center">
                    <a v-for="item in menus" :key="item.id" :href="item.url"
                        class="text-sm font-semibold text-gray-600 hover:text-orange-600 transition">
                        {{ item.label }}
                    </a>
                    <button
                        class="bg-black text-white px-6 py-2.5 rounded-full text-sm font-bold hover:bg-orange-600 transition duration-300">
                        Contact Us
                    </button>
                </div>

                <div class="md:hidden">
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
                    <a v-for="item in menus" :key="item.id" :href="item.url"
                        class="text-lg font-medium text-gray-800 py-2 border-b border-gray-50">
                        {{ item.label }}
                    </a>
                    <button class="bg-orange-600 text-white w-full py-3 rounded-xl font-bold">Contact Us</button>
                </div>
            </div>
        </Transition>
    </nav>
</template>

<script setup>
import { ref } from 'vue';
import { Menu, X } from 'lucide-vue-next';
import { usePage } from '@inertiajs/vue3';
const isOpen = ref(false);

const $page = usePage();
const [websiteName, slogan, menus] = [$page.props.setting.site_name, $page.props.setting.tagline, $page.props.setting.menus]
console.log(menus)
</script>