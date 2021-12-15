module.exports = {
  mode: "jit",
  purge: {
    content: [
      "./resources/views/theme/**/*.blade.php",
      "./resources/views/components/**/*.blade.php",
      "./resources/js/shop/**/*.{js,ts}",
    ],
  },
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      backgroundColor: {
        primary: "var(--color-bg-primary)",
        "primary-container": "var(--color-bg-primary-container)",
        secondary: "var(--color-bg-secondary)",
        "secondary-container": "var(--color-bg-secondary-container)",
        accent: "var(--color-bg-accent)",
        "accent-container": "var(--color-bg-accent-container)",
        default: "var(--color-bg-default)",
        surface: "var(--color-bg-surface)",
        "surface-variant": "var(--color-bg-surface-variant)",

        // "primary-dark": "var(--color-bg-primary-dark)",
        // "primary-container-dark": "var(--color-bg-primary-container-dark)",
        // "secondary-dark": "var(--color-bg-secondary-dark)",
        // "secondary-container-dark": "var(--color-bg-secondary-container-dark)",
        // "accent-dark": "var(--color-bg-accent-dark)",
        // "accent-container-dark": "var(--color-bg-accent-container-dark)",
        // "default-dark": "var(--color-bg-default-dark)",
        // "surface-dark": "var(--color-bg-surface-dark)",
        // "surface-variant-dark": "var(--color-bg-surface-variant-dark)",
      },
      textColor: {
        "on-primary": "var(--color-on-primary)",
        "on-primary-container": "var(--color-on-primary-container)",
        "on-secondary": "var(--color-on-secondary)",
        "on-secondary-container": "var(--color-on-secondary-container)",
        "on-accent": "var(--color-on-accent)",
        "on-accent-container": "var(--color-on-accent-container)",
        default: "var(--color-on-default)",
        "on-surface": "var(--color-on-surface)",
        "on-surface-variant": "var(--color-on-surface-variant)",

        // "on-primary-dark": "var(--color-on-primary-dark)",
        // "on-primary-container-dark": "var(--color-on-primary-container-dark)",
        // "on-secondary-dark": "var(--color-on-secondary-dark)",
        // "on-secondary-container-dark":
        //   "var(--color-on-secondary-container-dark)",
        // "on-accent-dark": "var(--color-on-accent-dark)",
        // "on-accent-container-dark": "var(--color-on-accent-container-dark)",
        // "default-dark": "var(--color-on-default-dark)",
        // "surface-dark": "var(--color-on-surface-dark)",
        // "surface-variant-dark": "var(--color-on-surface-variant-dark)",
      },
      borderColor: (theme) => ({
        ...theme("backgroundColor"),
      }),
    },
  },
  variants: {
    extend: {},
  },
  plugins: [require("@tailwindcss/forms")],
};
