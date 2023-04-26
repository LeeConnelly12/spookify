const defaultTheme = require('tailwindcss/defaultTheme')

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php', './storage/framework/views/*.php', './resources/views/**/*.blade.php', './resources/js/**/*.vue'],

  theme: {
    extend: {
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        green: {
          500: '#1ED760',
          400: '#1fdf64',
        },
        gray: {
          300: '#b3b3b3',
          400: '#414141',
          500: '#2A2A2A',
          600: '#7f7f7f',
          900: '#121212',
        },
      },
    },
  },

  plugins: [require('@tailwindcss/forms')],
}
