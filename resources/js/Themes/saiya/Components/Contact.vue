<template>
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-16">
                <h2 class="text-orange-600 font-black tracking-[0.3em] uppercase text-sm mb-3">Visit Us</h2>
                <h3 class="text-4xl md:text-5xl font-black text-gray-900">Our <span
                        class="text-gray-400 italic font-light">Facilities</span></h3>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <div
                    class="group bg-gray-50 rounded-[2.5rem] p-10 border border-gray-100 transition-all duration-500 hover:shadow-2xl hover:bg-white">
                    <div class="flex flex-col h-full">
                        <div class="mb-8 flex justify-between items-start">
                            <div class="bg-orange-600 p-4 rounded-2xl text-white">
                                <Factory :size="32" />
                            </div>
                            <span
                                class="text-[10px] font-black bg-black text-white px-4 py-1 rounded-full uppercase tracking-widest">Main
                                Production</span>
                        </div>

                        <h4 class="text-3xl font-black text-gray-900 mb-2">PT SAIYA INDONESIA - Jepara</h4>
                        <p class="text-orange-600 font-bold text-sm mb-8 uppercase tracking-widest">Central Java Branch
                        </p>

                        <div class="space-y-6 flex-grow">
                            <div class="flex gap-4">
                                <MapPin class="text-gray-400 shrink-0" :size="20" />
                                <p class="text-gray-600 leading-relaxed text-sm">
                                    Grombongan, Bapangan, Kec. Tahunan, Kabupaten Jepara, Jawa Tengah 59413
                                </p>
                            </div>
                            <div class="flex gap-4">
                                <Phone class="text-gray-400 shrink-0" :size="20" />
                                <p class="text-gray-600 text-sm">+62 291 123 4567</p>
                            </div>
                            <div class="flex gap-4">
                                <Mail class="text-gray-400 shrink-0" :size="20" />
                                <p class="text-gray-600 text-sm">jepara@saiyaindonesia.co.id</p>
                            </div>
                        </div>

                        <a href="https://maps.google.com/?q=PT+Saiya+Indonesia+Jepara" target="_blank"
                            class="mt-10 inline-flex items-center justify-center gap-2 bg-black text-white px-8 py-4 rounded-xl font-bold hover:bg-orange-600 transition duration-300 w-full">
                            Buka di Google Maps
                            <ExternalLink :size="18" />
                        </a>
                    </div>
                </div>

                <div
                    class="group bg-gray-50 rounded-[2.5rem] p-10 border border-gray-100 transition-all duration-500 hover:shadow-2xl hover:bg-white">
                    <div class="flex flex-col h-full">
                        <div class="mb-8 flex justify-between items-start">
                            <div
                                class="bg-black p-4 rounded-2xl text-white group-hover:bg-orange-600 transition-colors">
                                <Warehouse :size="32" />
                            </div>
                            <span
                                class="text-[10px] font-black bg-orange-600 text-white px-4 py-1 rounded-full uppercase tracking-widest">Assembly
                                & Logistic</span>
                        </div>

                        <h4 class="text-3xl font-black text-gray-900 mb-2">PT SAIYA INDONESIA - Cirebon</h4>
                        <p class="text-orange-600 font-bold text-sm mb-8 uppercase tracking-widest">West Java Branch</p>

                        <div class="space-y-6 flex-grow">
                            <div class="flex gap-4">
                                <MapPin class="text-gray-400 shrink-0" :size="20" />
                                <p class="text-gray-600 leading-relaxed text-sm">
                                    Kawasan Industri Cirebon, Kec. Tengah Tani, Kabupaten Cirebon, Jawa Barat 45153
                                </p>
                            </div>
                            <div class="flex gap-4">
                                <Phone class="text-gray-400 shrink-0" :size="20" />
                                <p class="text-gray-600 text-sm">+62 231 987 6543</p>
                            </div>
                            <div class="flex gap-4">
                                <Mail class="text-gray-400 shrink-0" :size="20" />
                                <p class="text-gray-600 text-sm">cirebon@saiyaindonesia.co.id</p>
                            </div>
                        </div>

                        <a href="https://maps.google.com/?q=Guitar+Factory+Cirebon" target="_blank"
                            class="mt-10 inline-flex items-center justify-center gap-2 bg-black text-white px-8 py-4 rounded-xl font-bold hover:bg-orange-600 transition duration-300 w-full">
                            Buka di Google Maps
                            <ExternalLink :size="18" />
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>
</template>

<script setup>
import { MapPin, Phone, Mail, Factory, Warehouse, ExternalLink } from 'lucide-vue-next';
</script>