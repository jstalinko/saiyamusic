<template>
    <AppLayout>
        <article class="pt-32 pb-24 bg-white">
            <header class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-16">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-50 text-orange-600 text-xs font-black uppercase tracking-widest mb-6">
                    <Calendar :size="14" />
                    <span>12 Januari 2026</span>
                    <span class="mx-2 text-orange-200">|</span>
                    <span>Corporate News</span>
                </div>

                <h1 class="text-4xl md:text-6xl font-black text-gray-900 leading-[1.1] mb-8">
                    Saiya Indonesia Resmi Membuka Workshop Baru di Jawa Tengah
                </h1>

                <div class="flex items-center justify-center gap-4 text-gray-500">
                    <img src="https://i.pravatar.cc/150?u=saiya"
                        class="w-10 h-10 rounded-full border-2 border-orange-600" alt="Author" />
                    <div class="text-left">
                        <p class="text-sm font-bold text-gray-900">Admin Saiya</p>
                        <p class="text-xs italic">Production Manager</p>
                    </div>
                </div>
            </header>

            <div class="max-w-6xl mx-auto px-4 mb-16">
                <div class="aspect-[21/9] rounded-[2rem] overflow-hidden shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?q=80&w=2000"
                        class="w-full h-full object-cover" alt="New Factory Facility" />
                </div>
            </div>

            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="prose prose-lg prose-orange max-w-none text-gray-600 leading-relaxed">
                    <p
                        class="text-xl text-gray-900 font-medium mb-8 leading-relaxed italic border-l-4 border-orange-600 pl-6">
                        "Ekspansi ini merupakan langkah strategis kami untuk memenuhi permintaan pasar global yang terus
                        meningkat, terutama dari wilayah Eropa dan Amerika Utara."
                    </p>

                    <p class="mb-6">
                        JEPARA — PT SAIYA INDONESIA hari ini meresmikan fasilitas workshop terbaru yang berlokasi di
                        wilayah industri strategis Jawa Tengah. Pabrik seluas 5.000 meter persegi ini dirancang khusus
                        untuk meningkatkan kapasitas produksi instrumen custom dan seri terbatas (limited edition).
                    </p>

                    <h3 class="text-2xl font-black text-gray-900 mt-12 mb-4">Teknologi Ramah Lingkungan</h3>
                    <p class="mb-6">
                        Fasilitas baru ini tidak hanya fokus pada kuantitas, tetapi juga keberlanjutan. Kami menerapkan
                        sistem pengelolaan limbah kayu yang terintegrasi dan menggunakan energi panel surya untuk
                        mendukung operasional harian. Hal ini sejalan dengan visi kami untuk menjadi produsen alat musik
                        yang bertanggung jawab terhadap ekosistem.
                    </p>

                    <div class="my-12 grid grid-cols-2 gap-4">
                        <img src="https://images.unsplash.com/photo-1550985616-10810253b84d?q=80&w=800"
                            class="rounded-2xl" />
                        <img src="https://images.unsplash.com/photo-1510915361894-db8b60106cb1?q=80&w=800"
                            class="rounded-2xl" />
                    </div>

                    <p class="mb-6">
                        Dengan adanya workshop baru ini, PT SAIYA INDONESIA optimis dapat memangkas waktu tunggu (lead
                        time) pesanan custom hingga 30%, memberikan pengalaman yang lebih baik bagi musisi di seluruh
                        dunia yang telah mempercayakan suaranya kepada produk kami.
                    </p>
                </div>

                <div
                    class="mt-16 pt-8 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="flex gap-2">
                        <span
                            class="px-4 py-2 bg-gray-100 rounded-lg text-xs font-bold text-gray-600">#FactoryUpdate</span>
                        <span class="px-4 py-2 bg-gray-100 rounded-lg text-xs font-bold text-gray-600">#Expansion</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-sm font-bold text-gray-400">Share:</span>
                        <button class="text-gray-400 hover:text-orange-600 transition">
                            <Facebook :size="20" />
                        </button>
                        <button class="text-gray-400 hover:text-orange-600 transition">
                            <Twitter :size="20" />
                        </button>
                        <button class="text-gray-400 hover:text-orange-600 transition">
                            <LinkIcon :size="20" />
                        </button>
                    </div>
                </div>
            </div>
        </article>
    </AppLayout>
</template>

<script setup>
import AppLayout from '../AppLayout.vue'
import { Calendar, Facebook, Twitter, Link as LinkIcon } from 'lucide-vue-next'
</script>

<style scoped>
/* Styling tambahan untuk elemen prose jika tidak menggunakan @tailwindcss/typography */
.prose h3 {
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.prose p {
    margin-bottom: 1.5rem;
}
</style>