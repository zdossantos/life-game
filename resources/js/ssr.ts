import { createInertiaApp } from '@inertiajs/vue3';
import createServer from '@inertiajs/vue3/server';
import { renderToString } from '@vue/server-renderer';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createSSRApp, h, DefineComponent } from 'vue';
import { route as ziggyRoute } from 'ziggy-js';
import { SharedData } from '@/types';
import { createI18n } from 'vue-i18n';
import en from './i18n/locales/en';
import fr from './i18n/locales/fr';

type MessageSchema = typeof en;

createServer((page) =>
    createInertiaApp({
        page,
        render: renderToString,
        title: (title) => title,
        resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob('./pages/**/*.vue')).then((module: unknown) => {
            const component = module as { default: DefineComponent };
            return component.default;
        }),        setup({ App, props, plugin }) {
            const app = createSSRApp({ render: () => h(App, props) });

            type ZiggyConfig  = SharedData["ziggy"]
            const ziggyConfig = {
                ...(page.props.ziggy as ZiggyConfig),
                location: new URL((page.props.ziggy as SharedData["ziggy"]).location),
            };

            // Create route function...
            const route = (name: string, params?: any, absolute?: boolean) => ziggyRoute(name, params, absolute, ziggyConfig);

            // Make route function available globally...
            app.config.globalProperties.route = route;

            // Make route function available globally for SSR...
            if (typeof window === 'undefined') {
                global.route = route;
            }

            // i18n: use the locale detected server-side (from Accept-Language)
            const locale = (page.props as SharedData).locale ?? 'en';
            const i18n = createI18n<[MessageSchema], 'en' | 'fr'>({
                legacy: false,
                locale,
                fallbackLocale: 'en',
                messages: { en, fr },
            });

            app.use(plugin);
            app.use(i18n);

            return app;
        },
    }),
);
