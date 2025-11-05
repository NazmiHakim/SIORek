import defaultTheme from "tailwindcss/defaultTheme";
import tailwindcss from '@tailwindcss/vite';


/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                'biru-primary': '#125BFB',
                'danger-stroke': '#FB2C36',
                'danger-fill': '#FFE2E2',
                'warning-stroke': '#FF9D00',
                'warning-fill': '#FFEBD5',
                'warning-btn': '#FF9327',
                'caution-stroke': '#FFE000',
                'caution-fill': '#FFFBCE',
                'notice-stroke': '#0095FF',
                'notice-fill': '#FFEBD5',

            }
        },
    },
    plugins: [],
};
