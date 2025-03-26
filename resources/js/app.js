// resources/js/app.js
import '../css/app.css';
import './bootstrap';
import { offlineDB } from './services/offlineDB';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

// Глобальна змінна для перевірки онлайн-статусу
window.isOnline = navigator.onLine;
window.offlineDB = offlineDB;

// Слухачі онлайн/офлайн статусу
window.addEventListener('online', () => {
    window.isOnline = true;
    document.dispatchEvent(new Event('online'));
});

window.addEventListener('offline', () => {
    window.isOnline = false;
    document.dispatchEvent(new Event('offline'));
});

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// Реєстрація Service Worker
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/service-worker.js')
            .then((registration) => {
                console.log('Service Worker registration successful with scope: ', registration.scope);
            })
            .catch((error) => {
                console.error('Service Worker registration failed:', error);
            });
    });
}