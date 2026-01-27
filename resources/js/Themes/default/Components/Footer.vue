<template>
    <!-- Footer -->
    <footer class="backdrop-blur-xl bg-white/5 border-t border-white/20 py-8 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p class="mb-2 text-white font-medium">&copy; 2024 {{ websiteName }}. All rights reserved.</p>
            <p class="text-purple-300">{{ slogan }}</p>
        </div>
    </footer>
    <HookRenderer place="footer" />
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import HookRenderer from './HookRenderer.vue';
const $page = usePage();
const [websiteName, slogan] = [$page.props.setting.site_name, $page.props.setting.tagline]
</script>