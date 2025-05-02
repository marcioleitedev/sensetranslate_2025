import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { createPinia } from 'pinia'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'

const pages = import.meta.glob < DefineComponent > ('./Pages/**/*.vue')

createInertiaApp({
    resolve: name => {
        const page = pages[`./Pages/${name}.vue`]
        if (!page) throw new Error(`Página não encontrada: ${name}`)
        return page()
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })

        const pinia = createPinia()
        app.use(plugin)
        app.use(pinia)

        app.mount(el)
    },
})
