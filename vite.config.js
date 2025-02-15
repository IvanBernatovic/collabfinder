import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import path from 'path'

export default defineConfig({
  plugins: [
    laravel([
      'resources/css/app.css',
      'resources/js/app.js',
      'resources/js/icons.js'
    ]),
    vue({
      template: {
        transformAssetUrls: {
          // The Vue plugin will re-write asset URLs, when referenced
          // in Single File Components, to point to the Laravel web
          // server. Setting this to `null` allows the Laravel plugin
          // to instead re-write asset URLs to point to the Vite
          // server instead.
          base: null,

          // The Vue plugin will parse absolute URLs and treat them
          // as absolute paths to files on disk. Setting this to
          // `false` will leave absolute URLs un-touched so they can
          // reference assets in the public directory as expected.
          includeAbsolute: false
        }
      }
    })
  ],
  resolve: {
    alias: {
      Jetstream: path.resolve(__dirname, 'resources/js/Jetstream'),
      Components: path.resolve(__dirname, 'resources/js/Components'),
      Icons: path.resolve(__dirname, 'resources/js/Icons'),
      '@': path.resolve(__dirname, 'resources/js')
    }
  }
})
