import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {

  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php', 
    './resources/views/**/*.blade.php',
  ],

  theme: {

    extend: {
      
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },

      colors: {
        primary: '#144067',
        secondary: '#A99206',
      },

      maxWidth: {
        '40vw': '40vw',
        '30vw': '30vw',
        '20vw': '20vw',
        '15vw': '15vw'
      }

    }

  },

  plugins: [forms],

}