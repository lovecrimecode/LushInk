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
            colors: {
                dark: "#0A0A0C",
                wine: "#7A1531",
                wineLight: "#B53058",
                paper: "#1A1A1D",
            },
            fontFamily: {
                sans: ['Inter', 'sans-serif'],
            },
        },
    },
    
    plugins: [forms],
};
