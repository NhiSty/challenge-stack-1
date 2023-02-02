/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./assets/**/*.js",
        "./templates/**/*.html.twig",
        "./assets/**/*.css",
    ],
    theme: {
        extend: {
            minHeight: {
                "screen-1/2": "50vh",
                "screen-1/4": "25vh",
                "screen-3/4": "75vh",
            },
            height: {
                "screen-1/2": "50vh",
                "screen-1/4": "25vh",
                "screen-3/4": "75vh",
            },
        },
    },
    plugins: [],
}
