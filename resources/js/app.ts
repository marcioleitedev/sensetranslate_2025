import { createApp, h, DefineComponent } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
// @ts-ignore
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'

declare global {
    interface ImportMeta {
        glob<T = unknown>(pattern: string): Record<string, () => Promise<T>>;
    }
}

const pages = import.meta.glob<DefineComponent>('./Pages/**/*.vue')

createInertiaApp({
    resolve: name => {
        const page = pages[`./Pages/${name}.vue`]
        if (!page) throw new Error(`Página não encontrada: ${name}`)
        return page()
    },
    setup({ el, App, props }) {
        createApp({ render: () => h(App, props) }).mount(el)
    },
})
