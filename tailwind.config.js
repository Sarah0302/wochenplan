/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.php",
    "./assets/**/*.php",
    "./assets/**/*.js",
  ],
  safelist: [
    "bg-blue-500",
    "text-white",
    "text-center",
    "border-4"
  ],
  theme: {
    extend: {},
  },
  plugins: [],
};

