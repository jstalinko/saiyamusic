<template>
    <footer class="bg-black text-white pt-20 pb-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row justify-between items-start gap-12 mb-16">

                <div class="max-w-sm">
                    <h3 class="text-2xl font-black tracking-tighter mb-6">PT SAIYA <span
                            class="text-orange-600">INDONESIA</span></h3>
                    <p class="text-gray-500 leading-relaxed mb-8">
                        Membangun warisan musik Indonesia melalui kualitas instrumen kelas dunia sejak tahun 2005.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="p-3 bg-white/5 rounded-full hover:bg-orange-600 transition">
                            <Instagram :size="20" />
                        </a>
                        <a href="#" class="p-3 bg-white/5 rounded-full hover:bg-orange-600 transition">
                            <Facebook :size="20" />
                        </a>
                        <a href="#" class="p-3 bg-white/5 rounded-full hover:bg-orange-600 transition">
                            <Youtube :size="20" />
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-12 lg:gap-24">
                    <div>
                        <h4 class="text-xs font-black uppercase tracking-[0.2em] text-orange-600 mb-6">Explore</h4>
                        <ul class="space-y-4 text-sm text-gray-400 font-medium">
                            <li><a href="/contact" class="hover:text-white transition">Contact</a></li>
                            <li><a href="/page/about-us" class="hover:text-white transition">About Us</a></li>
                            <li><a href="/page/workshop" class="hover:text-white transition">Workshop</a></li>
                        </ul>
                    </div>


                </div>
            </div>

            <div
                class="pt-10 border-t border-white/10 flex flex-col md:flex-row justify-between gap-4 text-[11px] font-bold text-gray-600 uppercase tracking-widest">
                <p>© {{ new Date().getFullYear() }} PT SAIYA INDONESIA. Crafting Excellence.</p>
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