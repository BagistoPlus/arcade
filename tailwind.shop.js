module.exports = {
  mode: "jit",
  content: [
    "./resources/views/theme/**/*.blade.php",
    "./resources/views/components/**/*.blade.php",
    "./resources/js/shop/**/*.{js,ts}",
  ],
  theme: {
    extend: {
      colors: {
        primary: "#0041FF",
        "primary-dark": "#171E3C",
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
  plugins: [require("@tailwindcss/forms")],
};
