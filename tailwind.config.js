/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/views/**/*.blade.php",
    "./resources/js/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        primary: 'var(--lp-primary)',
        'primary-dark': 'var(--lp-primary-dark)',
        secondary: 'var(--lp-secondary)',
        accent: 'var(--lp-accent)',
        success: 'var(--lp-success)',
        warning: 'var(--lp-warning)',
        danger: 'var(--lp-danger)',
        info: 'var(--lp-info)',
        dark: 'var(--lp-dark)',
        'gray-dark': 'var(--lp-gray-dark)',
        gray: 'var(--lp-gray)',
        'gray-light': 'var(--lp-gray-light)',
        white: 'var(--lp-white)',
        bg: 'var(--lp-bg)',
      },
      spacing: {
        xs: 'var(--space-xs)',
        sm: 'var(--space-sm)',
        md: 'var(--space-md)',
        lg: 'var(--space-lg)',
        xl: 'var(--space-xl)',
      },
      borderRadius: {
        xs: 'var(--radius-xs)',
        sm: 'var(--radius-sm)',
        md: 'var(--radius-md)',
        lg: 'var(--radius-lg)',
        full: 'var(--radius-full)',
      },
      boxShadow: {
        card: 'var(--shadow-card)',
        hover: 'var(--shadow-hover)',
      }
    },
  },
  plugins: [],
}
