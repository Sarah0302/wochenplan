/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./assets/css/**/*.css",
    "./assets/js/**/*.js",
    "./**/*.php"
  ],
  safelist: [
    { pattern: /^bg-/, variants: ['hover', 'focus'] },
    { pattern: /^text-/, variants: ['hover', 'focus'] }
  ],
  theme: {
    extend: {},
  },
  plugins: [],
};
