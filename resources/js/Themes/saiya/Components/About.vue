<template>
    <section class="py-24 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center gap-16">

                <div class="w-full md:w-1/2 relative">
                    <div class="absolute -top-6 -left-6 w-32 h-32 bg-orange-100 rounded-full -z-10"></div>
                    <div class="absolute -bottom-10 -right-6 w-64 h-64 bg-gray-100 rounded-2xl -z-10"></div>

                    <div
                        class="relative rounded-2xl overflow-hidden shadow-2xl transform hover:scale-[1.02] transition duration-500">
                        <img :src="coverImage" alt="About SAIYA"
                            class="w-full h-[500px] object-cover" />
                        <div
                            class="absolute bottom-6 left-6 bg-white/90 backdrop-blur-md p-4 rounded-xl shadow-lg flex items-center gap-3">
                            <div class="bg-orange-600 p-2 rounded-lg text-white">
                                <Award :size="24" />
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Quality Certified
                                </p>
                                <p class="text-sm font-black text-gray-900">PT SAIYA INDONESIA</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-1/2">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-50 text-orange-600 text-sm font-bold mb-6">
                        <History :size="16" />
                        <span>ESTABLISHED March 2006</span>
                    </div>

                    <h2 class="text-4xl font-black text-gray-900 mb-6 leading-tight">
                        The Brief introduction of <span class="text-orange-600">PT SAIYA INDONESIA</span>
                    </h2>

                    <div v-if="description" class="space-y-4 text-gray-600 leading-relaxed text-lg prose prose-lg max-w-none line-clamp-[8]" v-html="description">
                    </div>
                    <div v-else class="space-y-4 text-gray-600 leading-relaxed text-lg">
                        <p>
                            Sai Ya Music LTD. majors in accoustic guitars,classical guitars and basses of middle and
                            high quality.
                            Because of the refined craftsmanship, fine quality,reasonable price and improving
                            after-sale service,we earn the reliance and praise from quite a number of our clients.
                        </p>
                    </div>

                    <div class="mt-10">
                        <Link href="/about-us"
                            class="group flex items-center gap-2 font-bold text-gray-900 hover:text-orange-600 transition">
                            Read more
                            <ArrowRight :size="20" class="group-hover:translate-x-2 transition-transform" />
                        </Link>
                    </div>
                </div>

            </div>
        </div>
    </section>
</template>

<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { imageUrl } from '@/helpers';
import { Award, History, ArrowRight } from 'lucide-vue-next';

const props = defineProps({
    images: {
        type: Array,
        default: () => []
    },
    description: {
        type: String,
        default: ''
    }
});

const coverImage = computed(() => {
    if (props.images && props.images.length > 0) {
        const img = props.images[0];
        if (img.startsWith('http')) return img;
        return '/storage/' + img;
    }
    return imageUrl('/images/factory.webp');
});
</script>