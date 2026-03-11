<template>
    <footer class="bg-black text-white pt-20 pb-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          

            <div class="flex justify-center">
                <img src="/public/logo.png" class="w-60" />
            </div>

            <div
                class="pt-10 border-t border-white/10 flex flex-col md:flex-row justify-between gap-4 text-[11px] font-bold text-gray-600 uppercase tracking-widest">
                <p>© {{ new Date().getFullYear() }} PT SAIYA INDONESIA</p>
                <div class="flex gap-6">
                    <a href="/page/privacy-policy" class="hover:text-white">Privacy Policy</a>
                    <a href="/page/terms-of-trade" class="hover:text-white">Terms of Trade</a>
                </div>
            </div>
        </div>
    </footer>
</template>

<script setup>
import { Instagram, Facebook, Youtube } from 'lucide-vue-next';
</script>