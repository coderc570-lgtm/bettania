module.exports = {
  content: [
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        primary: {"50":"#fff1f2","100":"#ffe4e6","200":"#fecdd3","300":"#fda4af","400":"#fb7185","500":"#f43f5e","600":"#e11d48","700":"#be123c","800":"#9f1239","900":"#881337","950":"#4c0519"},
        //Background
        'light-teal': '#e0f7fa',
        'light-gray': '#f5f5f5',
        //Text
        'dark-gray': '#212121',
        'medium-teal': '#26a69a',
        'rose': '#ff5757',

        'stone-gray': '#d7d7cf',
        'pale-peach': '#eeded1',
        'soft-gray': '#d3cec7',
        'deep-plum': '#21171c',

        'l-deep-plum': '#3a2732'
      }
    },
    fontFamily: {
      title: ['"Plantagenet Cherokee"', 'serif'],
      text: ['"Avenir Next"', 'sans-serif'],
    }
  },
  plugins: [],
  purge: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
};

