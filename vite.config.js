import { defineConfig } from 'vite'
import tailwindcss from "@tailwindcss/vite";
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import path from 'path'
import ui from '@nuxt/ui/vite'

export default defineConfig({
  plugins: [
    laravel({

    }),
    vue({
      template: {
        // required for Laravel Vite plugin
        transformAssetUrls: {
          base: null,
          includeAbsolute: false
        }
      }
    }),
    ui(),
    tailwindcss(),

  ],
  resolve: {
    alias: {
      Jetstream: path.resolve(__dirname, 'resources/js/Jetstream'),
      Components: path.resolve(__dirname, 'resources/js/Components'),
      Icons: path.resolve(__dirname, 'resources/js/Icons'),
      '@': path.resolve(__dirname, 'resources/js'),
      '~': path.resolve(__dirname, 'resources')
    }
  }
})
