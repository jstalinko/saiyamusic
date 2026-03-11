<template>
    <AppLayout>
        <div class="pt-24 pb-12 bg-white min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-amber-500 text-3xl text-center font-bold">About Us</h1>

                <!-- Zigzag Gallery -->
                <div v-if="images.length > 0" class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 py-12">
                    <!-- Column 1 -->
                    <div class="flex flex-col gap-4 md:gap-6 pt-12 md:pt-16">
                        <img v-if="images[0]"
                            :src="storageUrl(images[0])"
                            class="w-full h-56 md:h-72 object-cover rounded-2xl shadow-lg cursor-pointer transition-transform duration-300 hover:scale-105"
                            @mouseenter="selectedImage = storageUrl(images[0])"
                            alt="Gallery Image 1"
                            loading="lazy"
                        />
                    </div>
                    <!-- Column 2 -->
                    <div class="flex flex-col gap-4 md:gap-6">
                        <img v-if="images[1]"
                            :src="storageUrl(images[1])"
                            class="w-full h-72 md:h-96 object-cover rounded-2xl shadow-lg cursor-pointer transition-transform duration-300 hover:scale-105"
                            @mouseenter="selectedImage = storageUrl(images[1])"
                            alt="Gallery Image 2"
                            loading="lazy"
                        />
                        <img v-if="images[2]"
                            :src="storageUrl(images[2])"
                            class="w-full h-48 md:h-64 object-cover rounded-2xl shadow-lg cursor-pointer transition-transform duration-300 hover:scale-105"
                            @mouseenter="selectedImage = storageUrl(images[2])"
                            alt="Gallery Image 3"
                            loading="lazy"
                        />
                    </div>
                    <!-- Column 3 -->
                    <div class="flex flex-col gap-4 md:gap-6 pt-12 md:pt-24">
                        <img v-if="images[3]"
                            :src="storageUrl(images[3])"
                            class="w-full h-64 md:h-80 object-cover rounded-2xl shadow-lg cursor-pointer transition-transform duration-300 hover:scale-105"
                            @mouseenter="selectedImage = storageUrl(images[3])"
                            alt="Gallery Image 4"
                            loading="lazy"
                        />
                        <img v-if="images[4]"
                            :src="storageUrl(images[4])"
                            class="w-full h-56 md:h-72 object-cover rounded-2xl shadow-lg cursor-pointer transition-transform duration-300 hover:scale-105"
                            @mouseenter="selectedImage = storageUrl(images[4])"
                            alt="Gallery Image 5"
                            loading="lazy"
                        />
                    </div>
                    <!-- Column 4 -->
                    <div class="flex flex-col gap-4 md:gap-6 pt-4 md:pt-12">
                        <img v-if="images[5]"
                            :src="storageUrl(images[5])"
                            class="w-full h-64 md:h-80 object-cover rounded-2xl shadow-lg cursor-pointer transition-transform duration-300 hover:scale-105"
                            @mouseenter="selectedImage = storageUrl(images[5])"
                            alt="Gallery Image 6"
                            loading="lazy"
                        />
                    </div>
                </div>

                <!-- Text Section -->
                <div class="max-w-4xl mx-auto text-center mt-16 mb-24 px-4">
                    <h2 class="text-sm font-bold tracking-widest text-amber-500 uppercase mb-3">Discover Our Story</h2>
                    <h1 class="text-4xl md:text-5xl font-extrabold mb-8 text-gray-900 dark:text-white tracking-tight">About Us</h1>
                    <div class="space-y-6 text-lg text-gray-600 dark:text-gray-400 leading-relaxed text-left prose prose-lg max-w-none"
                        v-html="description">
                    </div>
                </div>

            </div>
        </div>

        <!-- Lightbox Modal -->
        <Transition name="fade">
            <div
                v-if="selectedImage"
                class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 backdrop-blur-md p-4 pointer-events-none"
            >
                <div class="relative max-w-6xl w-full flex justify-center pointer-events-auto" @mouseleave="selectedImage = null">
                    <button
                        @click="selectedImage = null"
                        class="fixed top-6 right-6 md:absolute md:-top-12 md:-right-12 text-white/70 hover:text-white text-5xl transition-colors cursor-pointer w-12 h-12 flex items-center justify-center bg-black/50 md:bg-transparent rounded-full z-[101]"
                    >
                        &times;
                    </button>
                    <img
                        :src="selectedImage"
                        class="w-full max-w-5xl h-auto max-h-[90vh] object-contain rounded-xl shadow-2xl cursor-zoom-out"
                        alt="Enlarged User Selection"
                        @click="selectedImage = null"
                    />
                </div>
            </div>
        </Transition>
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import AppLayout from '../AppLayout.vue';

const $props = defineProps({ jdata: Object });

const images = $props.jdata?.about_us_images || [];
const description = $props.jdata?.about_us_description || '';

const storageUrl = (path) => {
    if (!path) return '';
    if (path.startsWith('http')) return path;
    return '/storage/' + path;
};

const selectedImage = ref(null);
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>