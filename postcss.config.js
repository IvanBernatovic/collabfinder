module.exports = {
  plugins: [
    require('postcss-import'),
    require('autoprefixer'),
    require('tailwindcss'),
    require('postcss-nested'),
    require('postcss-custom-properties')
  ]
}
