import "./bootstrap";
// resources/js/app.js
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { InertiaProgress } from "@inertiajs/progress";
import "../css/app.css";

const theme = document.documentElement.dataset.theme;

createInertiaApp({
    resolve: async (name) => {
        try {
            return await import(`./Themes/${theme}/Pages/${name}.vue`);
        } catch (e) {
            return await import(`./Themes/default/Pages/${name}.vue`);
        }
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
});

InertiaProgress.init();
