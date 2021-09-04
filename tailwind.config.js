module.exports = {
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      backgroundImage: theme => ({
      //  'home-1': "url('/public/images/home-1.jpg')",
      //  'footer-texture': "url('/img/footer-texture.png')",
      })
    }
  },
  variants: {
    extend: {
      fontWeight: ['hover'],

      backgroundColor: ['odd'],
    },
  },
  plugins: [],
}
