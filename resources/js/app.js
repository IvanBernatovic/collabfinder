require('./bootstrap')

import Vue from 'vue'
import VueMeta from 'vue-meta'

import { App, plugin } from '@inertiajs/inertia-vue'
import PortalVue from 'portal-vue'
import { InertiaProgress } from '@inertiajs/progress'
import * as Sentry from '@sentry/browser'
import { Integrations } from '@sentry/tracing'

Vue.use(plugin)
Vue.use(PortalVue)
Vue.use(VueMeta)

const app = document.getElementById('app')

new Vue({
  render: h =>
    h(App, {
      props: {
        initialPage: JSON.parse(app.dataset.page),
        resolveComponent: name =>
          import(`./Pages/${name}`).then(module => module.default)
      }
    })
}).$mount(app)

InertiaProgress.init({
  // The delay after which the progress bar will
  // appear during navigation, in milliseconds.
  delay: 250,

  // The color of the progress bar.
  color: '#29d',

  // Whether to include the default NProgress styles.
  includeCSS: true,

  // Whether the NProgress spinner will be shown.
  showSpinner: false
})

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
