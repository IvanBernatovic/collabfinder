import('./bootstrap')
import 'vue-toastification/dist/index.css'

import * as Sentry from '@sentry/browser'
import { Integrations } from '@sentry/tracing'

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import Toast from 'vue-toastification'

import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'

import Layout from '@/Layouts/Layout.vue'

createInertiaApp({
  progress: {
    delay: 250,
    color: '#29d',
    includeCSS: true,
    showSpinner: false
  },
  resolve: async name => {
    const page = await resolvePageComponent(
      `./Pages/${name}.vue`,
      import.meta.glob('./Pages/**/*.vue')
    )

    if (page.layout === null) {
      return page
    }

    if (page.default.layout === null) {
      return page
    }
    page.default.layout = page.default.layout || Layout
    return page
  },
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(Toast, {
        transition: 'Vue-Toastification__fade',
        timeout: 2500
      })
      .mount(el)

    if (import.meta.env.VITE_APP_ENV === 'production') {
      Sentry.init({
        Vue,
        dsn: import.meta.env.VITE_SENTRY_LARAVEL_DSN,
        autoSessionTracking: true,
        integrations: [new Integrations.BrowserTracing()],

        // We recommend adjusting this value in production, or using tracesSampler
        // for finer control
        tracesSampleRate: 1.0
      })
    }
  }
})
