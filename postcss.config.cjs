module.exports = {
  plugins: [
    require('postcss-import'),
    require('tailwindcss/nesting'),
    require('autoprefixer'),
    require('postcss-custom-properties'),
    require('tailwindcss')
  ]
}
