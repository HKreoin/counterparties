import './bootstrap';
import '../css/app.css';

import {createApp, h} from 'vue'
import {createInertiaApp, Head, Link} from '@inertiajs/inertia-vue3'
import {ZiggyVue} from '../../vendor/tightenco/ziggy';


const el = document.getElementById('app')

createInertiaApp({
    title: (title) => `Counterparty App ${title}`,
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .component('Head', Head)
            .component('Link', Link)
            .mount(el)
    },
    progress: {
        color: "white",
        includeCSS: true,
        showSpinner: true,
    },
})
