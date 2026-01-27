<template>
    <section v-show="slides.length > 0" class="relative min-h-screen pt-20 flex items-center overflow-hidden bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="grid md:grid-cols-2 gap-12 items-center">

                <!-- TEXT -->
                <div class="z-10 order-2 md:order-1">
                    <Transition name="fade-slide" mode="out-in" appear>
                        <div :key="textKey">
                            <span class="text-orange-600 font-bold tracking-widest uppercase text-sm mb-4 block">
                                {{ slides[currentIndex]?.subtitle }}
                            </span>
                            <h1 class="text-5xl md:text-7xl font-black text-gray-900 leading-tight mb-6">
                                {{ slides[currentIndex]?.title }}
                            </h1>
                            <p class="text-gray-600 text-lg mb-8 max-w-lg">
                                {{ slides[currentIndex]?.description }}
                            </p>
                        </div>
                    </Transition>

                    <div class="flex gap-4">
                        <Link class="bg-black text-white px-8 py-4 rounded-full font-bold hover:scale-105 transition"
                            v-if="slides[currentIndex]?.url" :href="slides[currentIndex]?.url">
                            Explore Models
                        </Link>
                        <div class="flex items-center gap-2">
                            <div v-for="(_, i) in slides" :key="i"
                                :class="['h-2 rounded-full transition-all duration-300', currentIndex === i ? 'w-8 bg-orange-600' : 'w-2 bg-gray-300']">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- IMAGE -->
                <div class="relative order-1 md:order-2 flex justify-center">
                    <div
                        class="absolute w-[300px] h-[300px] bg-orange-200/50 rounded-full blur-3xl -z-10 animate-pulse" />

                    <Transition name="guitar-swap" mode="out-in" appear>
                        <!-- v-if biar gak blank pas image belum siap -->
                        <div v-if="imageReady" :key="imgKey" class="img-wrap">
                            <img :src="slides[currentIndex]?.image" class="w-full max-w-[400px] img-idle"
                                alt="Guitar Model" loading="eager" decoding="async" />
                        </div>

                        <!-- fallback skeleton -->
                        <div v-else class="w-[400px] h-[400px] rounded-2xl bg-gray-200 animate-pulse" />
                    </Transition>
                </div>

            </div>
        </div>
    </section>
</template>
<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted, computed, watch } from 'vue';

const props = defineProps({
    banners: { type: Array, default: () => [] }
});

const slides = computed(() => props.banners);
const currentIndex = ref(0);
const imageReady = ref(false);
let timer = null;

const textKey = computed(() => {
    const s = slides.value[currentIndex.value];
    return s?.title + '|' + s?.subtitle; // key text stabil
});

const imgKey = computed(() => {
    const s = slides.value[currentIndex.value];
    return s?.image || currentIndex.value; // key gambar pakai URL
});

function preloadImage(src) {
    return new Promise((resolve) => {
        if (!src) return resolve(false);
        const img = new Image();
        img.onload = () => resolve(true);
        img.onerror = () => resolve(false);
        img.src = src;
    });
}

async function setSlide(index) {
    imageReady.value = false;

    const next = slides.value[index];
    // preload current + next biar swap halus
    await preloadImage(next?.image);

    currentIndex.value = index;
    imageReady.value = true;

    // preload next berikutnya (opsional, bikin makin smooth)
    const nextIndex = (index + 1) % slides.value.length;
    preloadImage(slides.value[nextIndex]?.image);
}

const startTimer = () => {
    if (timer) clearInterval(timer);
    if (slides.value.length > 1) {
        timer = setInterval(() => {
            const nextIndex = (currentIndex.value + 1) % slides.value.length;
            setSlide(nextIndex);
        }, 5000);
    }
};

watch(
    () => slides.value,
    (val) => {
        if (val?.length) {
            setSlide(0);
            startTimer();
        }
    },
    { immediate: true }
);

onMounted(() => {
    // sudah di-handle watch immediate
});

onUnmounted(() => {
    if (timer) clearInterval(timer);
});
</script>
<style scoped>
/* TEXT TRANSITION */
.fade-slide-enter-active,
.fade-slide-leave-active {
    transition: all 450ms cubic-bezier(0.22, 1, 0.36, 1);
}

.fade-slide-enter-from {
    opacity: 0;
    transform: translateY(14px);
}

.fade-slide-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}

/* IMAGE SWAP TRANSITION */
.guitar-swap-enter-active,
.guitar-swap-leave-active {
    transition: all 520ms cubic-bezier(0.22, 1, 0.36, 1);
}

.guitar-swap-enter-from {
    opacity: 0;
    transform: translateY(18px) scale(0.96);
    filter: blur(6px);
}

.guitar-swap-leave-to {
    opacity: 0;
    transform: translateY(-18px) scale(0.96);
    filter: blur(6px);
}

/* WRAP biar transform gak "pecah" sama layout */
.img-wrap {
    will-change: transform, opacity;
}

/* IDLE ANIMATION (FLOAT + ROTATE) */
.img-idle {
    will-change: transform;
    transform-origin: center center;
    animation: floatRotate 4.5s ease-in-out infinite;
}

@keyframes floatRotate {
    0% {
        transform: translateY(0px) rotate(-1.5deg);
    }

    50% {
        transform: translateY(-10px) rotate(1.5deg);
    }

    100% {
        transform: translateY(0px) rotate(-1.5deg);
    }
}
</style>