require('./bootstrap')

import Vue from 'vue'

import { InertiaProgress } from '@inertiajs/progress'
import * as Sentry from '@sentry/browser'
import { Integrations } from '@sentry/tracing'

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'

createInertiaApp({
  resolve: name => require(`./Pages/${name}`),
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) })
      .use(plugin)
      .mount(el)

    if (process.env.MIX_APP_ENV === 'production') {
      Sentry.init({
        Vue,
        dsn: process.env.MIX_SENTRY_LARAVEL_DSN,
        autoSessionTracking: true,
        integrations: [new Integrations.BrowserTracing()],

        // We recommend adjusting this value in production, or using tracesSampler
        // for finer control
        tracesSampleRate: 1.0
      })
    }
  }
})

InertiaProgress.init({
  delay: 250,
  color: '#29d',
  includeCSS: true,
  showSpinner: false
})
