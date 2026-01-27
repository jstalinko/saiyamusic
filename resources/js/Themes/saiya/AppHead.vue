<template>

    <Head>
        <base :href="setting.base_url" />
        <title>
            {{ meta?.title ?? defaultTitle }}
        </title>
        <meta name="description" :content="meta?.description" />
        <meta name="keywords" :content="meta?.description" />
        <meta name="author" :content="setting.site_name" />
        <!-- openGraph -->
        <meta property="og:title" :content="meta?.title ?? defaultTitle" />
        <meta property="og:description" :content="meta?.description" />
        <meta property="og:type" :content="meta?.type ?? 'website'" />
        <meta property="og:url" :content="meta?.url" />
        <meta property="og:image" :content="meta?.image ?? defaultImage" />
        <!-- twitter -->
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" :content="meta?.title ?? defaultTitle" />
        <meta name="twitter:description" :content="meta?.description" />
        <meta name="twitter:image" :content="meta?.image ?? defaultImage" />

    </Head>
</template>
<script setup>
import { usePage, Head } from '@inertiajs/vue3';
import { ref } from 'vue';
const $page = usePage();
const meta = ref($page.props.j_inertia_meta);
const setting = ref($page.props.setting);
const defaultTitle = setting.value.site_name + ' - ' + setting.value.tagline;
const defaultImage = setting.value.base_url + '/storage' + setting.value.icon;

</script>