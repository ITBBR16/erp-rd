// tailwind-pdf.config.js (untuk PDF)
/** @type {import('tailwindcss').Config} */
export default {
    content: [
      "./resources/views/repair/csr/preview/preview-qc.blade.php",
      "./resources/views/repair/csr/preview/preview-tt.blade.php",
    ],
    theme: {
      extend: {},
    },
    plugins: [
      require('flowbite/plugin'),
      require('tailwind-scrollbar'),
    ],
  }
  