/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './public/**/*.html',
    './src/**/*.{js,jsx,ts,tsx,vue}',
    'node_modules/flowbite-vue/**/*.{js,jsx,ts,tsx,vue}',
    'node_modules/flowbite/**/*.{js,jsx,ts,tsx}'
  ],
  theme: {
    extend: {
      colors: {
        'sp-primary': '#5c836e', // please refer to style.css
        'sp-secondary': '#467e60',
        'sp-tertiary': '#edf8f5',
        'sp-danger': '#c81e1e', // 'sp-danger'
        'sp-gray': '#6b7280',
        'sp-dark': '#000000'
      },
      height: {
        '500': '500px'
      }
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
}

