require('./bootstrap')

import Vue from 'vue'

import * as Sentry from '@sentry/browser'
import { Integrations } from '@sentry/tracing'

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import Toast from 'vue-toastification'

import 'vue-toastification/dist/index.css'

import Layout from './Layouts/Layout'

createInertiaApp({
  progress: {
    delay: 250,
    color: '#29d',
    includeCSS: true,
    showSpinner: false
  },
  resolve: name => {
    const page = require(`./Pages/${name}`).default

    if (page.layout === null) {
      return page
    }

    page.layout = page.layout || Layout

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
