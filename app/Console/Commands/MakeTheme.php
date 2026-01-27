<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class MakeTheme extends Command
{
    protected $signature = 'make:theme {name}';
    protected $description = 'Create a new theme structure';

    public function handle()
    {
        $name = $this->argument('name');
        $theme = Str::lower($name);
        $fs = new Filesystem;

        $basePath = resource_path("js/Themes/{$theme}");

        // Directories
        $directories = [
            "{$basePath}",
            "{$basePath}/Components",
            "{$basePath}/Pages",
        ];

        foreach ($directories as $dir) {
            if (!$fs->exists($dir)) {
                $fs->makeDirectory($dir, 0755, true);
            }
        }

        // .keep file
        $fs->put("{$basePath}/Components/.keep", "");

        // --------------------------
        // Create Home.vue
        // --------------------------
        $homeVue = <<<VUE
<template>
<AppLayout>
    <div>
        <h1>Home Page - {$name} Theme</h1>
    </div>
</AppLayout>
</template>

<script setup>
import AppLayout from '../AppLayout.vue';
</script>

<style scoped>
</style>
VUE;

        $fs->put("{$basePath}/Pages/Home.vue", $homeVue);

        // --------------------------
        // Create Single.vue
        // --------------------------
        $singleVue = <<<VUE
<template>
<AppLayout>
    <div>
        <h1>Single Page - {$name} Theme</h1>
    </div>
</AppLayout>
</template>

<script setup>
import AppLayout from '../AppLayout.vue';
</script>

<style scoped>
</style>
VUE;

        $fs->put("{$basePath}/Pages/Single.vue", $singleVue);
        $fs->put("{$basePath}/Pages/SingleFilter.vue", $singleVue);
        $fs->put("{$basePath}/Pages/PostFilter.vue", $homeVue);
        $fs->put("{$basePath}/Pages/Search.vue", $homeVue);

        // --------------------------
        // Create theme.json
        // --------------------------
        $themeJson = <<<JSON
{
    "theme_name": "{$name}",
    "theme_author": "jadicms",
    "theme_version": "1.0.0",
    "theme_description": "Default Theme",
    "theme_url": "https://javaradigital.com",
    "theme_demo_url": "https://jadicms.com",
    "theme_screenshot": "https://placehold.co/300x200/8d6e63/FFFFFF?text={$name}+THEME",
    "theme_license": "MIT",
    "theme_tags": [
        "default",
        "blog",
        "article",
        "news",
        "cms"
    ]
}
JSON;


        // --------------------------
        // Create ./Components/HookRenderer.vue
        // --------------------------
        $hookRendererVue = <<<VUE
<script setup>
const props = defineProps({
    place: String,
})

import { usePage } from '@inertiajs/vue3'

const page = usePage()

// Isi HTML yang dikirim dari server
const html = page.props.hooks?.[props.place] ?? ''
</script>

<template>
    <div v-html="html"></div>
</template>

VUE;

        $fs->put("{$basePath}/Components/HookRenderer.vue", $hookRendererVue);
        $fs->put("{$basePath}/theme.json", $themeJson);

        $appHead = <<<APPHEAD
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
const \$page = usePage();
const meta = ref(\$page.props.j_inertia_meta);
const setting = ref(\$page.props.setting);
const defaultTitle = setting.value.site_name + ' - ' + setting.value.tagline;
const defaultImage = setting.value.base_url + '/storage' + setting.value.icon;

</script>
APPHEAD;

        $appLayout = <<<APPLAYOUT
<template>
    <AppHead />
    <div>
    <slot />
    </div>
</template>
<script setup>
import AppHead from './AppHead.vue';
</script>


APPLAYOUT;

        $fs->put("{$basePath}/AppHead.vue", $appHead);
        $fs->put("{$basePath}/AppLayout.vue", $appLayout);

        $this->info("Theme '{$name}' created successfully!");

        return Command::SUCCESS;
    }
}
