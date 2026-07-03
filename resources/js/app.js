import { createInertiaApp } from "@inertiajs/vue3";
import { ZiggyVue } from "ziggy-js";
import DefaultLayout from "@/Layout/DefaultLayout.vue";

createInertiaApp({
    layout: () => DefaultLayout,
    withApp(app) {
        app.use(ZiggyVue);
    },
});
