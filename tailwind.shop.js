const colors = require("tailwindcss/colors");

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
  content: [
    "./resources/views/theme/**/*.blade.php",
    "./resources/views/webkul/**/*.blade.php",
    "./resources/views/components/**/*.blade.php",
    "./resources/ts/shop/**/*.{js,ts}",
    "./vendor/rappasoft/laravel-livewire-tables/resources/views/**/*.blade.php",
  ],
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        primary: withOpacity("--color-primary"),
        "on-primary": withOpacity("--color-on-primary"),
        "primary-container": withOpacity("--color-primary-container"),
        "on-primary-container": withOpacity("--color-on-primary-container"),

        secondary: withOpacity("--color-secondary"),
        "on-secondary": withOpacity("--color-on-secondary"),
        "secondary-container": withOpacity("--color-container"),
        "on-secondary-container": withOpacity("--color-on-secondary-container"),

        tertiary: withOpacity("--color-tertiary"),
        "on-tertiary": withOpacity("--color-on-tertiary"),
        "tertiary-container": withOpacity("--color-tertiary-container"),
        "on-tertiary-container": withOpacity("--color-on-tertiary-container"),

        error: withOpacity("--color-error"),
        "on-error": withOpacity("--color-on-error"),
        "error-container": withOpacity("--color-error-container"),
        "on-error-container": withOpacity("--color-on-error-container"),

        background: withOpacity("--color-background"),
        "on-background": withOpacity("--color-on-background"),

        surface: withOpacity("--color-surface"),
        "on-surface": withOpacity("--color-on-surface"),
        "surface-variant": withOpacity("--color-surface-variant"),
        "on-surface-variant": withOpacity("--color-on-surface-variant"),

        outline: withOpacity("--color-outline"),
      },
    },
    screen: {
      sm: "576px",
      md: "768px",
      lg: "992px",
      xl: "1200px",
      "2xl": "1400px",
    },
    container: {
      center: true,
      padding: {
        DEFAULT: "1rem",
        sm: "2rem",
        lg: "4rem",
        xl: "5rem",
        "2xl": "6rem",
      },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [
    // require("@tailwindcss/forms"),
    require("./resources/ts/plugins/forms"),
    require("@tailwindcss/typography"),
    require("@tailwindcss/aspect-ratio"),
    require("@tailwindcss/line-clamp"),
  ],
};
