const mix = require('laravel-mix')
const path = require('path')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
  .webpackConfig({
    resolve: {
      alias: {
        Jetstream: path.resolve(__dirname, 'resources/js/Jetstream'),
        Components: path.resolve(__dirname, 'resources/js/Components')
      }
    },
    module: {
      rules: [
        {
          test: /\.(postcss)$/,
          use: [
            'vue-style-loader',
            { loader: 'css-loader', options: { importLoaders: 1 } },
            'postcss-loader'
          ]
        }
      ]
    }
  })
  .options({
    hmrOptions: {
      host: 'localhost',
      port: 9080
    }
  })
  .js('resources/js/app.js', 'public/js')
  .vue()
  .js('resources/js/icons.js', 'public/js')
  .postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss')
  ])
  .webpackConfig(require('./webpack.config'))
  .version()
  .disableNotifications()

mix.extract({
  to: 'js/fa-icons.js',
  libraries: /.*fontawesome.*/
})
