/** @type {import('tailwindcss').Config} */


const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue', // Inclure les fichiers Vue.js
  ],
    
    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [
      require('@tailwindcss/forms'), // Ajouter le plugin @tailwindcss/forms ici
    ],
    
    
};










