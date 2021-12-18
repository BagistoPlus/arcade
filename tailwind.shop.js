function withOpacity(color) {
  return ({ opacityValue }) => {
    if (opacityValue) {
      return `rgba(var(${color}), ${opacityValue})`;
    }

    return `rgba(var(${color}), 1)`;
  };
}
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
        primary: withOpacity("--color-bg-primary"),
        "primary-container": withOpacity("--color-bg-primary-container"),
        secondary: withOpacity("--color-bg-secondary"),
        "secondary-container": withOpacity("--color-bg-secondary-container"),
        accent: withOpacity("--color-bg-accent"),
        "accent-container": withOpacity("--color-bg-accent-container"),
        default: withOpacity("--color-bg-default"),
        surface: withOpacity("--color-bg-surface"),
        "surface-variant": withOpacity("--color-bg-surface-variant"),

        "on-primary": withOpacity("--color-on-primary"),
        "on-primary-container": withOpacity("--color-on-primary-container"),
        "on-secondary": withOpacity("--color-on-secondary"),
        "on-secondary-container": withOpacity("--color-on-secondary-container"),
        "on-accent": withOpacity("--color-on-accent"),
        "on-accent-container": withOpacity("--color-on-accent-container"),
        "on-default": withOpacity("--color-on-default"),
        "on-surface": withOpacity("--color-on-surface"),
        "on-surface-variant": withOpacity("--color-on-surface-variant"),
      },
    },
    namedGroups: ["carousel", "product"],
  },
  variants: {
    extend: {},
  },
  plugins: [require("@tailwindcss/forms"), require("tailwindcss-named-groups")],
};
