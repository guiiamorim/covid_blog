const plugin = require('tailwindcss/plugin')

module.exports = {
  important: true,
  purge: [],
  theme: {
    extend: {},
  },
  variants: {},
  plugins: [
      plugin(function ({addComponents}) {
        const newComponents = {
          '.choices-inner-input': {
            outline: 'none',
            width: '100% !important',
            height: '2.5rem',
            borderRadius: '0.375rem',
            padding: '1.5rem',
          }
        }
        addComponents(newComponents)
      })
  ],
}
