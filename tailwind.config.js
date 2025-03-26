import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Comfortaa', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'primary': '#f44336',
                'primary-dark': '#d32f2f',
                'primary-light': '#ffcdd2',
                'secondary': '#2196f3',
                'secondary-dark': '#0069c0',
                'secondary-light': '#6ec6ff',
            },
        },
    },

    plugins: [forms],
};