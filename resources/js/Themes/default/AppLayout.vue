<template>
    <AppHead />
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
        <Navbar />
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- content -->
                <div class="lg:col-span-2 space-y-8">
                    <HookRenderer place="content_before" />
                    <slot />
                    <HookRenderer place="content_after" />
                </div>
                <SideBar />
            </div>
        </div>


        <Footer />
    </div>
</template>
<script setup>
import Navbar from './Components/Navbar.vue';
import Footer from './Components/Footer.vue';
import AppHead from './AppHead.vue';
import SideBar from './Components/SideBar.vue';
import HookRenderer from './Components/HookRenderer.vue';
</script>