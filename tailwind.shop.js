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
      colors: {
        primary: "var(--color-bg-primary)",
        "primary-container": "var(--color-bg-primary-container)",
        secondary: "var(--color-bg-secondary)",
        "secondary-container": "var(--color-bg-secondary-container)",
        accent: "var(--color-bg-accent)",
        "accent-container": "var(--color-bg-accent-container)",
        default: "var(--color-bg-default)",
        surface: "var(--color-bg-surface)",
        "surface-variant": "var(--color-bg-surface-variant)",

        "on-primary": "var(--color-on-primary)",
        "on-primary-container": "var(--color-on-primary-container)",
        "on-secondary": "var(--color-on-secondary)",
        "on-secondary-container": "var(--color-on-secondary-container)",
        "on-accent": "var(--color-on-accent)",
        "on-accent-container": "var(--color-on-accent-container)",
        "on-default": "var(--color-on-default)",
        "on-surface": "var(--color-on-surface)",
        "on-surface-variant": "var(--color-on-surface-variant)",
      },
    },
    namedGroups: ["carousel", "product"],
  },
  variants: {
    extend: {},
  },
  plugins: [require("@tailwindcss/forms"), require("tailwindcss-named-groups")],
};
