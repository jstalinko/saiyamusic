<template>
    <section class="py-24 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
                <div class="max-w-xl">
                    <h2 class="text-sm font-black text-orange-600 uppercase tracking-[0.3em] mb-3">Highlight</h2>
                    <h3 class="text-4xl md:text-5xl font-black text-gray-900 leading-tight">
                        Featured <span class="italic text-gray-400">Instruments</span>
                    </h3>
                </div>
                <div class="flex gap-3">
                    <button
                        class="prev-btn p-4 rounded-full border border-gray-200 hover:bg-black hover:text-white transition-all">
                        <ChevronLeft :size="24" />
                    </button>
                    <button
                        class="next-btn p-4 rounded-full border border-gray-200 hover:bg-black hover:text-white transition-all">
                        <ChevronRight :size="24" />
                    </button>
                </div>
            </div>

            <Swiper :modules="[Autoplay, Navigation, Pagination]" :slides-per-view="1" :space-between="20" :loop="true"
                :autoplay="{
                    delay: 3000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true
                }" :navigation="{
                    nextEl: '.next-btn',
                    prevEl: '.prev-btn',
                }" :breakpoints="{
                    '640': { slidesPerView: 2, spaceBetween: 20 },
                    '1024': { slidesPerView: 3, spaceBetween: 30 },
                    '1280': { slidesPerView: 4, spaceBetween: 30 }
                }" class="pb-12">
                <SwiperSlide v-for="product in products" :key="product.id">
                    <ProductCard :product="product" />
                </SwiperSlide>
            </Swiper>

        </div>
    </section>
</template>

<script setup>
import { ChevronLeft, ChevronRight } from 'lucide-vue-next';
import ProductCard from './ProductCard.vue';

// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay, Navigation, Pagination } from 'swiper/modules';

// Import Swiper styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
defineProps({ products: Array | Object });
</script>

<style scoped>
/* Menghilangkan shadow default swiper jika ada */
.swiper {
    width: 100%;
    height: 100%;
    padding-bottom: 50px !important;
    /* Ruang untuk shadow card */
}

/* Custom transition agar pergerakan slide lebih mewah */
:deep(.swiper-wrapper) {
    transition-timing-function: cubic-bezier(0.16, 1, 0.3, 1);
}
</style>