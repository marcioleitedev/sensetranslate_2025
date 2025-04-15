import { createApp, h, DefineComponent } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'

const pages = import.meta.glob<DefineComponent>('./Pages/**/*.vue') // 👈 TIPA AQUI

createInertiaApp({
    resolve: name => {
        const page = pages[`./Pages/${name}.vue`]
        if (!page) throw new Error(`Página não encontrada: ${name}`)
        return page() // 👈 agora é um Promise<DefineComponent>
    },
    setup({ el, App, props }) {
        createApp({ render: () => h(App, props) }).mount(el)
    },
})
