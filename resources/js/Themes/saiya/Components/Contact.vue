<template>
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-16">
                <h2 class="text-orange-600 font-black tracking-[0.3em] uppercase text-sm mb-3">Visit Us</h2>
                <h3 class="text-4xl md:text-5xl font-black text-gray-900">Our <span
                        class="text-gray-400 italic font-light">Factories</span></h3>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <div class="group bg-gray-50 rounded-[2.5rem] p-10 border border-gray-100 transition-all duration-500 hover:shadow-2xl hover:bg-white"
                    v-for="office in offices" :key="office.name">
                    <div class="flex flex-col h-full">
                        <div class="mb-8 flex justify-between items-start">
                            <div class="bg-orange-600 p-4 rounded-2xl text-white">
                                <Factory :size="32" />
                            </div>
                            <span
                                class="text-[10px] font-black bg-black text-white px-4 py-1 rounded-full uppercase tracking-widest">{{
                                    office.name }}</span>
                        </div>

                        <h4 class="text-3xl font-black text-gray-900 mb-2">{{ office.name }}</h4>
                        <p class="text-orange-600 font-bold text-sm mb-8 uppercase tracking-widest">{{ office.province
                            }} {{ office.city }}</p>

                        <div class="space-y-6 flex-grow">
                            <div class="flex gap-4">
                                <MapPin class="text-gray-400 shrink-0" :size="20" />
                                <p class="text-gray-600 leading-relaxed text-sm">
                                    {{ office.address }}
                                </p>
                            </div>
                            <div class="flex gap-4">
                                <Phone class="text-gray-400 shrink-0" :size="20" />
                                <p class="text-gray-600 text-sm">{{ office.phone }}</p>
                            </div>
                            <div class="flex gap-4">
                                <Mail class="text-gray-400 shrink-0" :size="20" />
                                <p class="text-gray-600 text-sm">{{ office.email }}</p>
                            </div>
                        </div>

                        <a :href="office.map_url" target="_blank"
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
const props = defineProps({
    offices: Array,
});
</script>