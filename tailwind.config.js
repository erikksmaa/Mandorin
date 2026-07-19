import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./app/Livewire/**/*.php",
        "./app/View/Components/**/*.php",
    ],

    theme: {
        extend: {
            colors: {
                // Design System Mandorin — WAJIB KONSISTEN
                // Skala penuh (50-950) supaya bg-navy-500, bg-orange-600, dst tetap jalan
                navy: {
                    DEFAULT: '#1E2A4A',
                    50: '#eef1f7',
                    100: '#d7deeb',
                    200: '#b0bdd7',
                    300: '#889cc3',
                    400: '#617baf',
                    500: '#3d5a94',
                    600: '#2f4677',
                    700: '#24365c',
                    800: '#1E2A4A',
                    900: '#141d33',
                    950: '#0b101c',
                },
                orange: {
                    DEFAULT: '#F97316',
                    50: '#fff7ed',
                    100: '#ffedd5',
                    200: '#fed7aa',
                    300: '#fdba74',
                    400: '#fb923c',
                    500: '#F97316',
                    600: '#ea580c',
                    700: '#c2410c',
                    800: '#9a3412',
                    900: '#7c2d12',
                    950: '#431407',
                },
                verified: {
                    DEFAULT: '#059669',
                    50: '#ecfdf5',
                    100: '#d1fae5',
                    500: '#10b981',
                    600: '#059669',
                    700: '#047857',
                },
                amber: {
                    DEFAULT: '#F59E0B',
                    50: '#fffbeb',
                    100: '#fef3c7',
                    200: '#fde68a',
                    300: '#fcd34d',
                    400: '#fbbf24',
                    500: '#F59E0B',
                    600: '#d97706',
                    700: '#b45309',
                    800: '#92400e',
                    900: '#78350f',
                },
                danger: {
                    DEFAULT: '#DC2626',
                    50: '#fef2f2',
                    100: '#fee2e2',
                    500: '#ef4444',
                    600: '#DC2626',
                    700: '#b91c1c',
                },
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                mono: ['JetBrains Mono', ...defaultTheme.fontFamily.mono],
            },
        },
    },

    plugins: [
        forms,
    ],
};