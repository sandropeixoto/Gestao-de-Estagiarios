/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./index.html",
        "./src/**/*.{js,ts,jsx,tsx}",
    ],
    theme: {
        extend: {
            colors: {
                primary: '#7C3AED',
                secondary: '#A78BFA',
                cta: '#F97316',
                background: '#FAF5FF',
                brandText: '#4C1D95',
                muted: '#6B7280',
            },
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', 'sans-serif'],
            },
        },
    },
    plugins: [],
}
